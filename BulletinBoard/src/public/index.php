<?php
declare(strict_types=1);
session_start();

if ($_SERVER['REQUEST_METHOD'] === "GET") {
  $csrf = bin2hex(random_bytes(16));
  $_SESSION['csrf'] = $csrf;
} elseif ($_SERVER['REQUEST_METHOD'] === "POST") {
  $postCsrf = isset($_POST['csrf']) && is_string($_POST['csrf']) ? $_POST['csrf'] : '';
  $sessionCsrf = isset($_SESSION['csrf']) && is_string($_SESSION['csrf']) ? $_SESSION['csrf'] : '';

  if ($postCsrf === '' || $sessionCsrf === '' || $postCsrf !== $sessionCsrf) {
    header("Location: index.php");
    exit();
  }

  $name = isset($_POST['name']) && is_string($_POST['name']) ? $_POST['name'] : '';
  $content = isset($_POST['content']) && is_string($_POST['content']) ? $_POST['content'] : '';

  if ($name === "") {
    $_SESSION['flash']['name'] = "投稿者名を入力してください";
  }
  if (mb_strlen($name) > 17) {
    $_SESSION['flash']['name'] = "投稿者名を16文字以内で入力してください";
  }
  $_SESSION['original']['name'] = $name;

  if ($content === "") {
    $_SESSION['flash']['content'] = "投稿内容を入力してください";
  }
  if (mb_strlen($content) > 301) {
    $_SESSION['flash']['content'] = "投稿内容を300文字以内で入力してください";
  }
  $_SESSION['original']['content'] = $content;

  if (isset($_SESSION['flash']['name']) || isset($_SESSION['flash']['content'])) {
    header("Location: index.php");
    exit();
  } else {
    unset($_SESSION['flash'], $_SESSION['original']);
    $csrf = bin2hex(random_bytes(16));
    $_SESSION['csrf'] = $csrf;
  }
  echo $name;
  echo $content;

} else {
  header("Location: index.php");
  exit();
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
    <input type="text" name="name" id="name" value="<?php echo isset($_SESSION['original']['name']) ? $_SESSION['original']['name'] : ''; ?>"><br>
    <label for="content">投稿内容</label><br>
    <textarea name="content" id="content"><?php echo isset($_SESSION['original']['content']) ? $_SESSION['original']['content'] : ''; ?></textarea><br>
    <input type="hidden" name="csrf" value="<?php echo $_SESSION['csrf']; ?>">
    <button type="submit">投稿</button>
  </form>
</body>
</html>