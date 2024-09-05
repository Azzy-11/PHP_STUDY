<?php
declare(strict_types=1);
session_start();

require_once('../../libs/Csrf.php');

Csrf::setToken();
[$flash, $original] = Validation::setErrorParam();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規書籍登録 | Library</title>
</head>
<body>
  <h1>新規書籍登録</h1>
  <form action="../book.php" method="post">
    <label for="bookTitle">書籍タイトル</label><br>
    <input type="text" name="bookTitle" id="bookTitle" value="<?php echo isset($original['bookTitle']) ? htmlspecialchars($original['bookTitle'], ENT_QUOTES, 'UTF-8') : ''; ?>"><br>
    <?php echo isset($flash['bookTitle']) ? htmlspecialchars($flash['bookTitle'], ENT_QUOTES, 'UTF-8') . '<br>' : ''; ?>
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" name="type" value="301">
    <button type="submit">登録</button>
  </form>
</body>
</html>