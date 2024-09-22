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

  public function read(int $userId) : array {
    try {
      $select = $this->db->prepare("SELECT * FROM histories WHERE user_id = :userId");
      $select->bindValue(':userId', $userId, PDO::PARAM_INT);
      $select->execute();
      return $select->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());

    }
  }

  public function select(int $historyId) : array {
    $select = $this->db->prepare("SELECT * FROM histories WHERE id = :id");
    $select->bindValue(':id', $historyId);
    $select->execute();
    return $select->fetchAll(PDO::FETCH_ASSOC);
  }

  public function update(int $historyId, string $updatedAt) : void {
    $select = $this->db->prepare("UPDATE histories SET updated_at = :updatedAt WHERE id = :id");
    $select->bindValue(':id', $historyId, PDO::PARAM_INT);
    $select->bindValue(':updatedAt', $updatedAt, PDO::PARAM_INT);
    $select->execute();
  }

  public function isOccupied(array $histories) : bool {
    return (count($histories) === 1 && $histories[0]['created_at'] === $histories[0]['updated_at']) ? true : false;
  }
}