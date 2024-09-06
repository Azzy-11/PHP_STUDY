<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');
require_once('../libs/Book.php');
require_once('../libs/Auth.php');
require_once('../libs/Enum.php');

Auth::checkAuth();
Request::exceptPost();
Csrf::checkToken();
$type = (isset($_POST['type']) && is_string($_POST['type'])) ? $_POST['type'] : "";

$priv = isset($_SESSION['user']['admin']) ? $_SESSION['user']['admin'] : "";

if ($priv === 1) {
  match ($type) {
    OperationMode::registBook->value => registBook($db),
    OperationMode::rentBook->value => rentBook($db)
  };
}
if ($priv === 0) {
  match ($type) {
    OperationMode::rentBook->value => rentBook($db)
  };
}
if ($priv !== 1 || $priv !== 0) {
  Redirect::redirectTo('top');
}

/**
 * 書籍登録処理
 * @param PDO $db
 */
function registBook(PDO $db) : void {
  $bookTtl = Validation::checkRegBookValidation();
  $createBook = new Book($db);
  $createBook->insert($bookTtl);
}

function rentBook(PDO $db) : void {
  $bookId = Validation::checkRentBookValidation();
  var_dump($bookId);
  exit();
}