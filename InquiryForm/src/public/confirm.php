<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
  header("Location: index.php");
  exit;
}

$postToken = isset($_POST["csrfToken"]) && is_string($_POST["csrfToken"]) ? $_POST["csrfToken"] : '';
$sessionToken = isset($_SESSION['csrfToken']) ? $_SESSION['csrfToken'] : '';

if ($postToken === "" || $sessionToken === "" || $postToken !== $sessionToken) {
  header("Location: index.php");
  exit;
}

$name = isset($_POST["name"]) && is_string($_POST["name"]) ? $_POST["name"] : '';
$email = isset($_POST["email"]) && is_string($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : '';
$message = isset($_POST["message"]) && is_string($_POST["message"]) ? $_POST["message"] : '';

//バリデーション
if ($name === "") {
  $_SESSION['flash']['name'] = "お名前は必須項目です";
}
if (mb_strlen($name) > 17) {
  $_SESSION['flash']['name'] = "お名前は16文字以内で入力してください";
}
$_SESSION['original']['name'] = $name;

if ($email === "") {
  $_SESSION['flash']['email'] = "メールアドレスは必須項目です";
}
if (mb_strlen($email) > 257) {
  $_SESSION['flash']['email'] = "メールアドレスは256文字以内で入力してください";
}
$_SESSION['original']['email'] = $email;

if ($message === "") {
  $_SESSION['flash']['message'] = "お問い合わせ内容は必須項目です";
}
if (mb_strlen($message) > 301) {
  $_SESSION['flash']['message'] = "お問い合わせ内容は300文字以内で入力してください";
}
$_SESSION['original']['message'] = $message;

if ($name === "" || $email === "" | $message === "") {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
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
      <td><?php htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?php htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <th>お問い合わせ内容</th>
      <td><?php htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
  </table>
  <form action="send.php" method="post">
    <input type="hidden" name="name" value="<?php htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="email" value="<?php htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="message" value="<?php htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="csrfToken" value="<?php htmlspecialchars($postToken, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="submit" value="送信">
    <button type="button" onClick="history.back()">戻る</button>
  </form>
</body>
</html>