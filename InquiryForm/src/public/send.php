<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $postToken = isset($_POST["csrfToken"]) && is_string($_POST["csrfToken"]) ? $_POST["csrfToken"] : '';
  $sessionToken = isset($_SESSION['csrfToken']) ? $_SESSION['csrfToken'] : '';
  
  if ($postToken !== "" && $sessionToken !== "" && $postToken === $sessionToken) {
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    
    // 完了メール配信設定
    $to = htmlspecialchars($email, ENT_QUOTES, "UTF-8");
    $subject = "お問い合わせがありました";
    $headers = "From: ochi.azusa@spiral-platform.co.jp";
    $message = "お問い合わせ完了メール送信！";
    if (mail($to, $subject, $message, $headers)) {
      $resMsg = "お問い合わせが送信されました。";
    } else {
      $resMsg = "エラーが発生しました。もう一度お試しください。";
    }
  } else {
    header("Location: index.php");
    exit;
  }
} else {
  header("Location: index.php");
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
  <h1>お問い合わせフォーム 完了</h1>
  <p><?= $resMsg; ?></p>
  <p><a href="index.php">お問い合わせフォームに戻る</a></p>
</body>
</html>