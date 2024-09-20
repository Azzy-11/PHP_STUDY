<?php
declare(strict_types=1);

require_once('Redirect.php');

class History {
  public function __construct(private PDO $db, private ?int $id = null)
  {
  }

  public function insert(int $userId, string $bookId, string $bookTtl): void
  {
      $create = $this->db->prepare("INSERT INTO histories (user_id, book_id, book_title) VALUES (:userId, :bookId, :bookTtl)");
      $create->bindValue(':userId', $userId, PDO::PARAM_INT);
      $create->bindValue(':bookId', $bookId, PDO::PARAM_STR);
      $create->bindValue(':bookTtl', $bookTtl, PDO::PARAM_STR);
      $create->execute();
      unset($_SESSION['csrf']);
  }
}