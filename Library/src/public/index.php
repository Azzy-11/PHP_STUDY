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
    [$name, $email, $password, $rePassword] = Validation::checkRegisterValidation();
    $_SESSION['formData']['name'] = $name;
    $_SESSION['formData']['email'] = $email;
    $_SESSION['formData']['password'] = $password;
    $_SESSION['formData']['re:password'] = $rePassword;

    header("Location: comfirm.php");
    exit();

  case "102":
    Request::exceptPost();
    Csrf::checkToken();
    [$name, $email, $password, $rePassword] = Validation::checkRegisterValidation();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $createUser = new User($db);
    $createUser->insert($name, $email, $hashedPassword);
    break;
  
  default:
    header("Location: login.php");
    exit();
}
?>