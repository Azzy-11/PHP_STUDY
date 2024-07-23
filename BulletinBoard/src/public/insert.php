<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');
require_once('../libs/Post.php');

Request::exceptPost();
Csrf::validateToken();

[$name, $content] = Validation::validation();

$createPost = new Post($db);
$createPost->insert($name, $content);
