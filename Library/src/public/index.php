<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');
require_once('../libs/User.php');

$type = (isset($_POST['type']) && is_string($_POST['type'])) ? $_POST['type'] : "";
switch ($type) {
  case "101":
    Request::exceptPost();
    Csrf::checkToken();
    Validation::checkRegisterValidation();
    header("Location: comfirm.php");
    exit();

  case "102":
    Request::exceptPost();
    Csrf::checkToken();
    $name = (isset($_SESSION['formData']['name']) && is_string($_SESSION['formData']['name'])) ? $_SESSION['formData']['name'] : "";
    $email = (isset($_SESSION['formData']['email']) && is_string($_SESSION['formData']['email'])) ? $_SESSION['formData']['email'] : "";
    $password = (isset($_SESSION['formData']['password']) && is_string($_SESSION['formData']['password'])) ? password_hash($_SESSION['formData']['password'], PASSWORD_DEFAULT) : "";
    $createUser = new User($db);
    $createUser->insert($name, $email, $password);
    break;
  
  default:
    # code...
    break;
}
?>