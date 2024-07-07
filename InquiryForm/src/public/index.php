<?php
session_start();

require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');

$validation = new Validation();
[$flash, $original] = $validation->setValidatedErrorPram();
/*
$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
unset($_SESSION['flash']);
$original = isset($_SESSION['original']) ? $_SESSION['original'] : [];
unset($_SESSION['original']);*/

$csrf = new Csrf();
$csrfToken = $csrf->createToken();
$_SESSION['csrfToken'] = $csrfToken;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム</title>
</head>
<body>
  <h1>お問い合わせフォーム</h1>
  <form action="confirm.php" method="post">
    <label for="name">名前</label><br>
    <input type="text" name="name" id="name" value="<?php echo isset($original['name']) ? $original['name'] : '' ?>" required><br>
    <?php echo isset($flash['name']) ? $flash['name'] . '<br>' : ''; ?>

    <label for="email">メールアドレス</label><br>
    <input type="email" name="email" id="email" value="<?php echo isset($original['email']) ? $original['email'] : ''  ?>" required><br>
    <?php echo isset($flash['email']) ? $flash['email'] . '<br>' : ''; ?>

    <label for="message">お問い合わせ内容</label><br>
    <textarea name="message" id="message" required><?php echo isset($original['message']) ? $original['message'] : ''  ?></textarea><br>
    <?php echo isset($flash['message']) ? $flash['message'] . '<br>' : ''; ?>

    <input type="hidden" name="csrfToken" value="<?php echo $csrfToken; ?>">
    <button type="submit">送信</button>
  </form>
</body>
</html>