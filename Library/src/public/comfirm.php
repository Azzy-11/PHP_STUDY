<?php
declare(strict_types=1);
session_start();

$name = (isset($_SESSION['formData']['name']) && is_string($_SESSION['formData']['name'])) ? $_SESSION['formData']['name'] : "";
$email = (isset($_SESSION['formData']['email']) && is_string($_SESSION['formData']['email'])) ? $_SESSION['formData']['email'] : "";
$password = (isset($_SESSION['formData']['password']) && is_string($_SESSION['formData']['password'])) ? $_SESSION['formData']['password'] : "";

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録 | Library</title>
</head>
<body>
  <h1>新規登録 確認</h1>
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
      <th>パスワード</th>
      <td><?php echo str_repeat('*', strlen($password)); ?></td>
    </tr>
  </table>
</body>
</html>