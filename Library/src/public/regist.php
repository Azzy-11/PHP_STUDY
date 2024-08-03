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
  <form action="comfirm.php" method="post">
    <label for="name">名前</label><br>
    <input type="text" name="name" id="name"><br>
    <label for="email">メールアドレス</label><br>
    <input type="email" name="email" id="email"><br>
    <label for="password">パスワード</label><br>
    <input type="password" name="password" id="password"><br>
    <label for="re:password">パスワードの確認</label><br>
    <input type="password" name="re:password" id="re:password"><br>
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrf']; ?>"><br>
    <button type="submit">確認</button>
  </form>
</body>
</html>