<?php
declare(strict_types=1);
session_start();

require_once('../libs/Csrf.php');
require_once('../libs/Auth.php');

Auth::checkAuth();
Csrf::setToken();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Top | Library</title>
</head>
<body>
  <form action="index.php" method="post" id="logout">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" name="type" value="202">
  </form>
  <a href="#" onclick="document.getElementById('logout').submit(); return false;">ログアウト</a>
</body>
</html>