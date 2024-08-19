<?php
declare(strict_types=1);
session_start();

require_once('../libs/Csrf.php');

Csrf::setToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Login</title>
</head>
<body>
  <form action="index.php" method="post">
    <label for="loginId">メールアドレス</label>
    <input type="email" name="loginId">
    <label for="loginPw">パスワード</label>
    <input type="password" name="loginPw">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" name="type" value="201">
    <button type="submit">ログイン</button>
  </form>
  <a href="regist.php">新規登録はこちらから</a>
</body>
</html>