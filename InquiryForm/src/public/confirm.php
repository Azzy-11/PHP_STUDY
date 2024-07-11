<?php
declare(strict_types=1);

session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');

Request::redirectToIndexUnlessPost();
Csrf::validateToken();

Validation::validate();
$name = isset($_POST["name"]) && is_string($_POST["name"]) ? $_POST["name"] : '';
$email = isset($_POST["email"]) && is_string($_POST["email"]) ? filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL) : '';
$message = isset($_POST["message"]) && is_string($_POST["message"]) ? $_POST["message"] : '';
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
      <td><?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <th>メールアドレス</th>
      <td><?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
    <tr>
      <th>お問い合わせ内容</th>
      <td><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
  </table>
  <form action="send.php" method="post">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="message" value="<?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="csrfToken" value="<?php echo htmlspecialchars(Csrf::getToken(), ENT_QUOTES, 'UTF-8'); ?>">
    <button type="submit">送信</button>
    <button type="button" onClick="history.back()">戻る</button>
  </form>
</body>
</html>