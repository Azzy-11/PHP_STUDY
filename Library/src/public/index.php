<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');
require_once('../libs/User.php');
require_once('../libs/Auth.php');
require_once('../libs/Enum.php');

Request::exceptPost();
Csrf::checkToken();
$type = (isset($_POST['type']) && is_string($_POST['type'])) ? $_POST['type'] : "";

match ($type) {
  OperationMode::FromRegist->value => fromRegist("comfirm"),
  OperationMode::FromComfirm->value  => fromComfirm($db, false),
  OperationMode::FromAdminRegist->value  => fromRegist("adminComfirm"),
  OperationMode::FromAdminComfirm->value  => fromComfirm($db, true),
  OperationMode::Login->value  => login($db),
  OperationMode::Logout->value  => Auth::logout(),
};

/**
 * 登録画面から遷移して、バリデーションチェックして、確認ページに遷移
 * @param string $location 遷移先 
 */
function fromRegist(string $location) : void {
  [$name, $email, $password, $rePassword] = Validation::checkRegisterValidation();
  $_SESSION['formData'] = [
    'name' => $name,
    'email' => $email,
    'password' => $password,
    're:password' => $rePassword,
  ];
  Redirect::redirectTo($location);
}

/**
 * 確認画面から遷移して、バリデーションチェックして、dbに登録
 * @param PDO $db
 * @param bool $isAdmin 管理者権限 
 */
function fromComfirm(PDO $db, bool $isAdmin) : void {
  [$name, $email, $password] = Validation::checkRegisterValidation();
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $createUser = new User($db);
  $createUser->insert($name, $email, $hashedPassword, $isAdmin);
}

/**
 * ログイン処理
 * @param PDO $db 
 */
function login(PDO $db) : void {
  $user = new Auth($db);
  $user->checkCredentials();
}