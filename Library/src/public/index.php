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

  case "201":
    Request::exceptPost();
    Csrf::checkToken();
    $loginId = (isset($_POST['loginId']) && is_string($_POST['loginId'])) ? $_POST['loginId'] : "";
    $loginPw = (isset($_POST['loginPw']) && is_string($_POST['loginPw'])) ? $_POST['loginPw'] : "";

    try {
      $read = $db->prepare("SELECT id, password, name, admin FROM users WHERE email = :loginId AND deleted_at IS NULL");
      $read->bindValue(':loginId', $loginId, PDO::PARAM_STR);
      $read->execute();
      $user = $read->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
    }
    if (empty($user) || count($user) > 1) {
      header("Location: login.php");
      exit();
    }
    $userPw = $user[0]["password"];
    if (password_verify($loginPw, $userPw)) {
      $_SESSION['user'] = [
        "id" => $user[0]["id"],
        "name" => $user[0]["name"],
        "email" => $loginId,
        "admin" => $user[0]["admin"]
      ];
    } else {
      header("Location: login.php");
      exit();
    }
    break;
  
  default:
    header("Location: login.php");
    exit();
}
?>