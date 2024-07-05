<?php
session_start();

$flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : [];
unset($_SESSION['flash']);
$original = isset($_SESSION['original']) ? $_SESSION['original'] : [];
unset($_SESSION['original']);

$csrfToken = bin2hex(random_bytes(16));
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
    <input type="text" name="name" id="name" value="<?php isset($original['name']) ?? $original['name'] ?>" required><br>
    <?php isset($flash['name']) ?? $flash['name'] . '<br>' ?>

    <label for="email">メールアドレス</label><br>
    <input type="email" name="email" id="email" value="<?php isset($original['email']) ?? $original['email'] ?>" required><br>
    <?php isset($flash['email']) ?? $flash['email'] . '<br>' ?>

    <label for="message">お問い合わせ内容</label><br>
    <textarea name="message" id="message" required><?php isset($original['message']) ?? $original['message'] ?></textarea><br>
    <?php isset($flash['message']) ?? $flash['message'] . '<br>' ?>

    <input type="hidden" name="csrfToken" value="<?php $csrfToken; ?>">
    <button type="submit">送信</button>
  </form>
</body>
</html>