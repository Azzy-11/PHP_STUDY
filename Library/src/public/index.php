<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');
require_once('../libs/User.php');
require_once('../libs/Auth.php');

Request::exceptPost();
Csrf::checkToken();
$type = (isset($_POST['type']) && is_string($_POST['type'])) ? $_POST['type'] : "";

switch ($type) {
  case "101":
    [$name, $email, $password, $rePassword] = Validation::checkRegisterValidation();
    $_SESSION['formData'] = [
      'name' => $name,
      'email' => $email,
      'password' => $password,
      're:password' => $rePassword,
    ];
    Redirect::redirectTo("comfirm");
    break;

  case "102":
    [$name, $email, $password, $rePassword] = Validation::checkRegisterValidation();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $createUser = new User($db);
    $createUser->insert($name, $email, $hashedPassword);
    break;

  case "201":
    $user = new Auth($db);
    $user->checkCredentials();
    break;

  case "202":
    Auth::logout();
    break;
  
  default:
    Redirect::redirectTo("login");
    break;
}
?>