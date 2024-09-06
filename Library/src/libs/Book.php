<?php
declare(strict_types=1);

require_once('Redirect.php');

class Book {
  public function __construct(private PDO $db, private ?string $id = null)
  {
  }

  public function insert(string $bookTtl) : void {
    try {
      $select = $this->db->prepare("SELECT id FROM books ORDER BY created_at DESC LIMIT 1");
      $select->execute();
      $latest = $select->fetchAll(PDO::FETCH_ASSOC);

      if (count($latest) === 0) {
        $newId = "BK" . sprintf('%06d', 1);
      } else {
        $lastId = (int)mb_substr($latest[0]["id"], 2);
        $newId = "BK" . sprintf('%06d', ($lastId + 1));
      }
      
      $create = $this->db->prepare("INSERT INTO books (id, book_title) VALUES (:id, :bookTitle)");
      $create->bindValue(':id', $newId, PDO::PARAM_STR);
      $create->bindValue(':bookTitle', $bookTtl, PDO::PARAM_STR);
      $create->execute();
      unset($_SESSION['csrf'], $_SESSION['flash'], $_SESSION['original'], $_SESSION['formData']);
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
    } finally {
      Redirect::redirectTo("top");
    }
  }

  public function find() : array {
    try {
      $select = $this->db->prepare("SELECT * FROM books");
      $select->execute();
      return $select->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
    }
  }
}