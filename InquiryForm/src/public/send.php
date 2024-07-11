<?php
declare(strict_types=1);

session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');

Request::redirectToIndexUnlessPost();
Csrf::validateToken();

Validation::validate();
$name = isset($_POST["name"]) && is_string($_POST["name"]) ? $_POST["name"] : '';
$email = isset($_POST["email"]) && is_string($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : '';
$message = isset($_POST["message"]) && is_string($_POST["message"]) ? $_POST["message"] : '';

//PDO
try {
  $stmt = $db->prepare("INSERT INTO contacts (name, email, content) VALUES (:name, :email, :content)");
  $stmt->bindValue(':name', $name);
  $stmt->bindValue(':email', $email);
  $stmt->bindValue(':content', $message);
  $stmt->execute();
  echo "データが正常に挿入されました";
} catch (PDOException $e) {
  echo "エラー：" . $e->getMessage();
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