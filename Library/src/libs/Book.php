<?php
declare(strict_types=1);

require_once('Redirect.php');

class Book {
  public function __construct(private PDO $db, private ?string $id = null)
  {
  }

  public function insert(string $bookTtl) : void {
    try {
      $create = $this->db->prepare("INSERT INTO books (bookTitle) VALUES (:bookTitle)");
      $create->bindValue(':bookTitle', $bookTtl, PDO::PARAM_STR);
      $create->execute();
      unset($_SESSION['csrf'], $_SESSION['flash'], $_SESSION['original'], $_SESSION['formData']);
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
    } finally {
      Redirect::redirectTo("top");
    }
  }
}