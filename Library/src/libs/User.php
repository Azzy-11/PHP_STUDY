<?php
declare(strict_types=1);

require_once('Redirect.php');

class User {
  public function __construct(private PDO $db, private ?int $id = null)
  {
  }

  public function insert(string $name, string $email, string $password, bool $isAdmin = false) : void {
    try {
      $create = $this->db->prepare("INSERT INTO users (name, email, password, admin) VALUES (:name, :email, :password, :admin)");
      $create->bindValue(':name', $name, PDO::PARAM_STR);
      $create->bindValue(':email', $email, PDO::PARAM_STR);
      $create->bindValue(':password', $password, PDO::PARAM_STR);
      $create->bindValue(':admin', $isAdmin, PDO::PARAM_BOOL);
      $create->execute();
      unset($_SESSION['csrf'], $_SESSION['flash'], $_SESSION['original'], $_SESSION['formData']);
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
    } finally {
      Redirect::redirectTo("login");
    }
  }
}