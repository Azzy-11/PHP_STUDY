<?php
declare(strict_types=1);
session_start();

if ($_SERVER['REQUEST_METHOD'] !== "POST") {
  header("Location: regist.php");
  exit();
}

$postToken = (isset($_POST['csrfToken']) && is_string($_POST['csrfToken'])) ? $_POST['csrfToken'] : "";
$sessionToken = (isset($_SESSION['csrf']) && is_string($_SESSION['csrf'])) ? $_SESSION['csrf'] : "";
if ($postToken === "" || $sessionToken === "" || $postToken !== $sessionToken) {
  header("Location: regist.php");
  exit();
}

$name = (isset($_POST['name']) && is_string($_POST['name'])) ? $_POST['name'] : "";
$email = (isset($_POST['email']) && is_string($_POST['email'])) ? $_POST['email'] : "";
$password = (isset($_POST['password']) && is_string($_POST['password'])) ? $_POST['password'] : "";
$rePassword = (isset($_POST['re:password']) && is_string($_POST['re:password'])) ? $_POST['re:password'] : "";

if ($name === "") {
  $_SESSION['flash']['name'] = "名前を入力してください";
}
if (mb_strlen($name) > 65) {
  $_SESSION['flash']['name'] = "名前を64文字以下で入力してください";
}
$_SESSION['original']['name'] = $name;

if ($email === "") {
  $_SESSION['flash']['email'] = "メールアドレスを入力してください";
}
// $emailReg = "^[a-zA-Z0-9_\-]+(\.[a-zA-Z0-9_\-]+)*@([a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9]\.)+[a-zA-Z]{2,}$";
$emailReg = "/^(?=.{1,255}$)[a-zA-Z0-9_\-]+(\.[a-zA-Z0-9_\-]+)*@([a-zA-Z0-9][a-zA-Z0-9\-]*[a-zA-Z0-9]\.)+[a-zA-Z]{2,}$/";
if (preg_match($emailReg, $email) === 0) {
  $_SESSION['flash']['email'] = "メールアドレスを正しく入力してください";
}
$_SESSION['original']['email'] = $email;

if ($password === "") {
  $_SESSION['flash']['password'] = "パスワードを入力してください";
}
$passwordReg = "/^[a-zA-Z0-9.?\/\-!@]{8,24}$/";
if (preg_match($passwordReg, $password) === 0) {
  $_SESSION['flash']['password'] = "パスワードを正しく入力してください";
}
$_SESSION['original']['password'] = $password;

if ($rePassword === "" || $password !== $rePassword) {
  $_SESSION['flash']['re:password'] = "パスワードが一致しません";
}

if (isset($_SESSION['flash']['name']) || isset($_SESSION['flash']['email']) || isset($_SESSION['flash']['password']) || isset($_SESSION['flash']['re:password'])) {
  // header("Location: regist.php");
  // exit();
  echo $_SESSION['flash']['name'];
  echo $_SESSION['flash']['email'];
  echo $_SESSION['flash']['password'];
  echo $_SESSION['flash']['re:password'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録 | Library</title>
</head>
<body>
  <h1>新規登録 確認</h1>
  <table>
    <tr>
      <th>名前</th>
      <td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <th>パスワード</th>
      <td><?php echo str_repeat('*', strlen($password)); ?></td>
    </tr>
  </table>
</body>
</html>