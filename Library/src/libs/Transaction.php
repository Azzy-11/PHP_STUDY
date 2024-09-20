<?php
declare(strict_types=1);

require_once('User.php');
require_once('Book.php');
require_once('History.php');

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
  
      $userId = $userMdl->isExist();
  
      $books = $bookMdl->select($bookId);
      $bookNum = count($books);
  
      if ($bookNum !== 1) {
        echo "本1件じゃないよ";
        exit();
      }
      if ($bookNum === 1) {
        $borrowedAt = date('Y-m-d H:i:s');
        $bookMdl->update($bookId, $userId, $borrowedAt);
      }
  

      $bookTtl = $books[0]['book_title'];
      $historyMdl->insert($userId, $bookId, $bookTtl);

      $this->db->commit();

      echo "成功";
    } catch (PDOException $e) {
      $this->db->rollBack();
      throw new Exception("Database Error: " . $e->getMessage());
    }
  }
}