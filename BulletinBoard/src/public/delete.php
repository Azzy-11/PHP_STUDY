<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/dbConnect.php');
require_once('../libs/Post.php');

Request::exceptPost();
Csrf::validateToken();

$postId = (isset($_POST['postId']) && is_string($_POST['postId'])) ? $_POST['postId'] : null;
if (!$postId) {
  header("Location: index.php");
  exit();
}

$delPost = new Post($db, (int)$postId, null, null);
$post = $delPost->selectPost();


if (empty($post) || count($post) > 1) {
  unset($_SESSION['csrf']);
  header("Location: index.php");
  exit();
}

$delPost->deletePost();

