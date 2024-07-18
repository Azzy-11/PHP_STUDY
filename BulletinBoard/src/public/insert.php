<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');

Request::exceptPost();
Csrf::validateToken();

[$name, $content] = Validation::validation();

// CREATE
try {
  $create = $db->prepare("INSERT INTO posts (name, content) VALUE (:name, :content)");
  $create->bindValue(':name', $name);
  $create->bindValue(':content', $content);
  $create->execute();
  unset($_SESSION['csrf'], $_SESSION['flash'], $_SESSION['original']);
} catch (PDOException $e) {
  throw new Exception("Database Error: " . $e->getMessage());
}

header("Location: index.php");
exit;