<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');

Request::isBadRequest();
if (Request::isGet()) {
  Csrf::setToken();
} 
if (Request::isPost()) {
  if (Request::isFirstRequest()) {
    Csrf::setToken();
  } else {
    Csrf::validateToken();
    
    [$name, $content] = Validation::validation();
    [$flash, $original] = Validation::setValidatedErrorParam();

    Csrf::setToken();
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掲示板</title>
</head>
<body>
  <h1>掲示板</h1>
  <form action="" method="post">
    <label for="text">投稿者名</label><br>
    <input type="text" name="name" id="name" value="<?php echo isset($original['name']) ? $original['name'] : ''; ?>"><br>
    <?php echo isset($flash['name']) ? '<p>' . $flash['name'] . '</p>' : '';; ?>
    <label for="content">投稿内容</label><br>
    <textarea name="content" id="content"><?php echo isset($original['content']) ? $original['content'] : '';; ?></textarea><br>
    <?php echo isset($flash['content']) ? '<p>' . $flash['content'] . '</p>' : '';; ?>
    <input type="hidden" name="csrf" value="<?php echo Csrf::getToken(); ?>">
    <button type="submit">投稿</button>
  </form>
</body>
</html>