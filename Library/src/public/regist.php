<?php
declare(strict_types=1);
session_start();

$_SESSION['csrf'] = bin2hex(random_bytes(16));

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録 | Library</title>
</head>
<body>
  <h1>新規登録</h1>
  <form action="" method="post">
    <label for="name">氏名</label><br>
      <label for="surName">　姓</label>
      <input type="text" name="surName" id="surName">
      <label for="firstName">名</label>
      <input type="text" name="firstName" id="firstName"><br>
    <label for="email">メールアドレス</label><br>
    <input type="email" name="email" id="email"><br>
    <label for="password">パスワード</label><br>
    <input type="password" name="password" id="password"><br>
    <label for="confirm_password">パスワードの確認</label><br>
    <input type="password" name="confirm_password" id="confirm_password"><br>
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrf']; ?>"><br>
    <button type="submit">確認</button>
  </form>
</body>
</html>