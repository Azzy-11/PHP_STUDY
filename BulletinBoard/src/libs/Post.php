<?php
declare(strict_types=1);

require_once('Redirect.php');

class Post {
  public function __construct(private PDO $db, private ?int $id = null)
  {
  }

  public function insert(string $name, string $content): void
  {
    try {
      $create = $this->db->prepare("INSERT INTO posts (name, content) VALUES (:name, :content)");
      $create->bindValue(':name', $name, PDO::PARAM_STR);
      $create->bindValue(':content', $content, PDO::PARAM_STR);
      $create->execute();
      unset($_SESSION['csrf'], $_SESSION['flash'], $_SESSION['original']);

    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());

    } finally {
      Redirect::redirectToIndex();
    }
  }
  
  public function find(): array
  {
    try {
      $read = $this->db->prepare("SELECT * FROM posts WHERE deleted_at IS NULL");
      $read->execute();
      return $read->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());

    }
  }

  public function select(int $id): array
  {
    try {
      $read = $this->db->prepare("SELECT * FROM posts WHERE id = :id AND deleted_at IS NULL");
      $read->bindValue(':id', $id, PDO::PARAM_INT);
      $read->execute();
      return $read->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
      
      unset($_SESSION['csrf']);
      Redirect::redirectToIndex();
    }
  }

  public function delete(int $id): void
  {
    $post = self::select($id);
    self::checkCount($post);

    try {
      $del = $this->db->prepare("UPDATE posts SET deleted_at = NOW() WHERE id = :id");
      $del->bindValue(':id', $id, PDO::PARAM_INT);
      $del->execute();
    
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
    
    } finally {
      unset($_SESSION['csrf']);
      Redirect::redirectToIndex();
    }
  }

  public function checkCount(array $post) :void
  {
    if (empty($post) || count($post) > 1) {
      unset($_SESSION['csrf']);
      Redirect::redirectToIndex();
    }
  }
}