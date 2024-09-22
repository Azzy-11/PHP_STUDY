<?php
declare(strict_types=1);
session_start();

require_once('../libs/Csrf.php');
require_once('../libs/Auth.php');

Auth::checkAuth();
Csrf::setToken();

$priv = (isset($_SESSION['user']['admin']) && is_int($_SESSION['user']['admin'])) ? $_SESSION['user']['admin'] : 0;
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

  <li>
    <?php
    if ($priv === 1) {
      echo '<li><a href="admin/regBook.php">書籍登録</a></li>';
    }
    ?>
    <li><a href="bookList.php">書籍レンタル（一覧表設置）</a></li>
    <li><a href="mypage.php">マイページ</a></li>
  </li>

</body>
</html>