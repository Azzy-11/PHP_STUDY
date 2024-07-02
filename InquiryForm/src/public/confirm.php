<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = isset($_POST["name"]) && is_string($_POST["name"]) ? $_POST["name"] : '';
  $email = isset($_POST["email"]) && is_string($_POST["email"]) ? $_POST["email"] : '';
  $message = isset($_POST["message"]) && is_string($_POST["message"]) ? $_POST["message"] : '';
} else {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム</title>
</head>
<body>
  <h1>お問い合わせフォーム 確認</h1>
  <table>
    <tr>
      <th>名前</th>
      <td><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <th>お問い合わせ内容</th>
      <td><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
  </table>
  <form action="send.php" method="post">
    <input type="hidden" name="name" value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="email" value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="message" value="<?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="送信">
    <button type="button" onClick="history.back()">戻る</button>
  </form>
</body>
</html>