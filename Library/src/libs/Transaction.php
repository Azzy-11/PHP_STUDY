<?php
declare(strict_types=1);

require_once('Redirect.php');
require_once('User.php');
require_once('Book.php');
require_once('History.php');
require_once('Preset.php');

class Transaction {
  public function __construct(private PDO $db)
  {
  }

  public function rentBook(string $bookId) : void {
    try {
      $userMdl = new User($this->db);
      $bookMdl = new Book($this->db);
      $historyMdl = new History($this->db);

      $this->db->beginTransaction();

      $userId = Preset::getUserId();
      $users = $userMdl->select($userId);
      if ($userMdl->isExist($users) === false) {
        Redirect::redirectTo("bookList");
      }
  
      $books = $bookMdl->select($bookId);

      if ($bookMdl->isAvailable($books) === false) {
        Redirect::redirectTo("bookList");
      }

      $borrowedAt = date('Y-m-d H:i:s');
      $bookMdl->update($bookId, $userId, $borrowedAt);

      $bookTtl = $books[0]['book_title'];
      $historyMdl->insert($userId, $bookId, $bookTtl);

      $this->db->commit();

    } catch (PDOException $e) {
      $this->db->rollBack();
      throw new Exception("Database Error: " . $e->getMessage());

    } finally {
      unset($_SESSION['csrf']);
      Redirect::redirectTo("bookList");
      
    }
  }
}