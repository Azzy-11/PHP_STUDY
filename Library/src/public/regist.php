<?php
declare(strict_types=1);
session_start();

require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');

Csrf::setToken();
[$flash, $original] = Validation::setErrorParam();

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
  <form action="index.php" method="post">
    <label for="name">名前</label><br>
    <input type="text" name="name" id="name" value="<?php echo isset($original['name']) ? htmlspecialchars($original['name'], ENT_QUOTES, 'UTF-8') : ''; ?>"><br>
    <?php echo isset($flash['name']) ? htmlspecialchars($flash['name'], ENT_QUOTES, 'UTF-8') . '<br>' : ''; ?>

    <label for="email">メールアドレス</label><br>
    <input type="email" name="email" id="email" value="<?php echo isset($original['email']) ? htmlspecialchars($original['email'], ENT_QUOTES, 'UTF-8') : ''; ?>"><br>
    <?php echo isset($flash['email']) ? htmlspecialchars($flash['email'], ENT_QUOTES, 'UTF-8') . '<br>' : ''; ?>

    <label for="password">パスワード</label><br>
    <input type="password" name="password" id="password" value="<?php echo isset($original['password']) ? htmlspecialchars($original['password'], ENT_QUOTES, 'UTF-8') : ''; ?>"><br>
    <?php echo isset($flash['password']) ? htmlspecialchars($flash['password'], ENT_QUOTES, 'UTF-8') . '<br>' : ''; ?>

    <label for="re:password">パスワードの確認</label><br>
    <input type="password" name="re:password" id="re:password"><br>
    <?php echo isset($flash['re:password']) ? htmlspecialchars($flash['re:password'], ENT_QUOTES, 'UTF-8') . '<br>' : ''; ?>
    
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" name="type" value="101">
    <button type="submit">確認</button>
  </form>
</body>
</html>