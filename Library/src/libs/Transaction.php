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

      
      $userId = Preset::getUserId();
      $users = $userMdl->select($userId);
      if ($userMdl->isExist($users) === false) {
        Redirect::redirectTo("bookList");
        exit();
      }
      
      $books = $bookMdl->select($bookId);
      
      if ($bookMdl->isAvailable($books) === false) {
        Redirect::redirectTo("bookList");
        exit();
      }
      
      $this->db->beginTransaction();

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
      exit();
    }
  }

  public function returnBook(int $historyId) : void {
    try {
      $userMdl = new User($this->db);
      $bookMdl = new Book($this->db);
      $historyMdl = new History($this->db);

      
      $userId = Preset::getUserId();
      $users = $userMdl->select($userId);
      if ($userMdl->isExist($users) === false) {
        Redirect::redirectTo("mypage");
        exit();
      }
      
      $histories = $historyMdl->select($historyId);
      if ($historyMdl->isOccupied($histories) === false) {
        Redirect::redirectTo("mypage");
        exit();
      }
      
      // historyRecord側チェック
      $historyBorrower = (int)$histories[0]['user_id'];
      if ($userId !== $historyBorrower) {
        Redirect::redirectTo("mypage");
        exit();
      }
      
      // bookRecord側チェック
      $bookId = $histories[0]['book_id'];
      $books = $bookMdl->select($bookId);
      if ($bookMdl->isOccupied($books) === false) {
        Redirect::redirectTo("mypage");
        exit();
      }
      $bookBorrower = $books[0]['user_id'];
      if ($userId !== $bookBorrower) {
        Redirect::redirectTo("mypage");
        exit();
      }
      
      $this->db->beginTransaction();
      
      $updatedAt = date('Y-m-d H:i:s');
      $historyMdl->update($historyId, $updatedAt);
      $bookMdl->update($bookId);

      $this->db->commit();

    } catch (PDOException $e) {
      $this->db->rollBack();
      throw new Exception("Database Error: " . $e->getMessage());

    } finally {
      unset($_SESSION['csrf']);
      Redirect::redirectTo("mypage");
      exit();
      
    }
  }
}