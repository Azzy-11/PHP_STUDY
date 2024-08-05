<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');

Request::exceptPost();

Csrf::checkToken();
[$name, $email, $password] = Validation::checkValidation();
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