<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/dbConnect.php');

Request::exceptPost();
Csrf::validateToken();

$postId = (isset($_POST['postId']) && is_string($_POST['postId'])) ? $_POST['postId'] : null;
if (!$postId) {
  header("Location: index.php");
  exit();
}

try {
  $read = $db->prepare("SELECT * FROM posts WHERE id = :id AND deleted_at IS NULL");
  $read->bindValue(':id', $postId, PDO::PARAM_INT);
  $read->execute();
  $post = $read->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
  throw new Exception("Database Error: " . $e->getMessage());
  
  unset($_SESSION['csrf']);
  header("Location: index.php");
  exit();
}

if (empty($post)) {
  unset($_SESSION['csrf']);
  header("Location: index.php");
  exit();
}

// DELETE
try {
  $del = $db->prepare("UPDATE posts SET deleted_at = NOW() WHERE id = :id");
  $del->bindValue(':id', $postId, PDO::PARAM_INT);
  $del->execute();

} catch (PDOException $e) {
  throw new Exception("Database Error: " . $e->getMessage());

} finally {
  unset($_SESSION['csrf']);
  header("Location: index.php");
  exit();
}
