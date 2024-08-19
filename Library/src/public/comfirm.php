<?php
declare(strict_types=1);
session_start();

$name = (isset($_SESSION['formData']['name']) && is_string($_SESSION['formData']['name'])) ? $_SESSION['formData']['name'] : "";
$email = (isset($_SESSION['formData']['email']) && is_string($_SESSION['formData']['email'])) ? $_SESSION['formData']['email'] : "";
$password = (isset($_SESSION['formData']['password']) && is_string($_SESSION['formData']['password'])) ? $_SESSION['formData']['password'] : "";
$rePassword = (isset($_SESSION['formData']['re:password']) && is_string($_SESSION['formData']['re:password'])) ? $_SESSION['formData']['re:password'] : "";
unset($_SESSION['flash'], $_SESSION['original'], $_SESSION['formData']);
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
  <form action="index.php" method="post">
    <input type="hidden" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="password" value="<?php echo htmlspecialchars($password, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="re:password" value="<?php echo htmlspecialchars($rePassword, ENT_QUOTES, 'UTF-8'); ?>">
    <input type="hidden" name="csrfToken" value="<?php echo isset($_SESSION['csrf']) ? htmlspecialchars($_SESSION['csrf'], ENT_QUOTES, 'UTF-8') : ''; ?>">
    <input type="hidden" name="type" value="102">
    <button type="button" onClick="history.back()">戻る</button>
    <button type="submit">登録</button>
  </form>
</body>
</html>