<?php
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');

$method = new Request($_SERVER["REQUEST_METHOD"]);
$method->redirectToIndex();

$postToken = isset($_POST["csrfToken"]) && is_string($_POST["csrfToken"]) ? $_POST["csrfToken"] : '';
$sessionToken = isset($_SESSION['csrfToken']) ? $_SESSION['csrfToken'] : '';

$csrf = new Csrf($postToken, $sessionToken);
$csrf->redirectToIndex();

$name = isset($_POST["name"]) && is_string($_POST["name"]) ? $_POST["name"] : '';
$email = isset($_POST["email"]) && is_string($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : '';
$message = isset($_POST["message"]) && is_string($_POST["message"]) ? $_POST["message"] : '';

//バリデーション
$validation = new Validation($name, $email, $message);
$validation->validate();

// 完了メール配信設定
$to = htmlspecialchars($email, ENT_QUOTES, "UTF-8");
$subject = "お問い合わせがありました";
$headers = "From: ochi.azusa@spiral-platform.co.jp";
$body = "お問い合わせ完了メール送信！";
if (mail($to, $subject, $body, $headers)) {
  $resMsg = "お問い合わせが送信されました。";
} else {
  $resMsg = "エラーが発生しました。もう一度お試しください。";
}

unset($_SESSION['csrfToken']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム</title>
</head>
<body>
  <h1>お問い合わせフォーム 完了</h1>
  <p><?php echo $resMsg; ?></p>
  <p><a href="index.php">お問い合わせフォームに戻る</a></p>
</body>
</html>