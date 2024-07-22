<?php
declare(strict_types=1);

class Post {
  public function __construct(private PDO $db, private ?int $id = null, private ?string $name = null, private ?string $content = null)
  {
  }

  public function insertPost(): void {
    try {
      $create = $this->db->prepare("INSERT INTO posts (name, content) VALUES (:name, :content)");
      $create->bindValue(':name', $this->name, PDO::PARAM_STR);
      $create->bindValue(':content', $this->content, PDO::PARAM_STR);
      $create->execute();
      unset($_SESSION['csrf'], $_SESSION['flash'], $_SESSION['original']);

    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());

    } finally {
      header("Location: index.php");
      exit;
    }
  }
  
  public function findPost(): array {
    try {
      $read = $this->db->prepare("SELECT * FROM posts WHERE deleted_at IS NULL");
      $read->execute();
      return $read->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());

    }
  }

  public function selectPost(): array {
    try {
      $read = $this->db->prepare("SELECT * FROM posts WHERE id = :id AND deleted_at IS NULL");
      $read->bindValue(':id', $this->id, PDO::PARAM_INT);
      $read->execute();
      return $read->fetchAll(PDO::FETCH_ASSOC);
    
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
      
      unset($_SESSION['csrf']);
      header("Location: index.php");
      exit();
    }
  }

  public function deletePost($post): void {
    self::checkPost($post);

    try {
      $del = $this->db->prepare("UPDATE posts SET deleted_at = NOW() WHERE id = :id");
      $del->bindValue(':id', $this->id, PDO::PARAM_INT);
      $del->execute();
    
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
    
    } finally {
      unset($_SESSION['csrf']);
      header("Location: index.php");
      exit();
    }
  }

  public function checkPost($post) :void {
    if (empty($post) || count($post) > 1) {
      unset($_SESSION['csrf']);
      header("Location: index.php");
      exit();
    }
  }
}