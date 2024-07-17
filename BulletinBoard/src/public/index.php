<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');

Request::isBadRequest();
if (Request::isGet()) {
  Csrf::setToken();
  // READ
  try {
    $stmt = $db->prepare("SELECT * FROM posts");
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    echo "エラー：" . $e->getMessage();
  }
} 
if (Request::isPost()) {
  if (Request::isFirstRequest()) {
    Csrf::setToken();

    // READ
    try {
      $stmt = $db->prepare("SELECT * FROM posts");
      $stmt->execute();
      $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "エラー：" . $e->getMessage();
    }
  } else {
    Csrf::validateToken();
    
    [$name, $content] = Validation::validation();
    [$flash, $original] = Validation::setValidatedErrorParam();

    Csrf::setToken();

    // CREATE
    try {
      $stmt = $db->prepare("INSERT INTO posts (name, content) VALUE (:name, :content)");
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':content', $content);
      $stmt->execute();
    } catch (PDOException $e) {
      echo "エラー：" . $e->getMessage();
    }

    // READ
    try {
      $stmt = $db->prepare("SELECT * FROM posts");
      $stmt->execute();
      $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      echo "エラー：" . $e->getMessage();
    }
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

  <div>
    <?php foreach ($posts as $post) {
      $postId = htmlspecialchars($post['id'], ENT_QUOTES);
      $postName = htmlspecialchars($post['name'], ENT_QUOTES);
      $postContent = htmlspecialchars($post['content'], ENT_QUOTES);
      $postTime = htmlspecialchars($post['updated_at'], ENT_QUOTES);

      echo <<<EOT
      <p>
        {$postContent} | {$postName} | {$postTime} | 
        <form action="delete.php" method="post" onsubmit="return confirm('本当に削除しますか？');">
          <input type="hidden" name="postId" value="{$postId}">
          <input type="hidden" name="deleteCsrf" value="{Csrf::getToken()}">
          <button type="submit">削除</button>
        </form>
      </p>
      EOT;
    } ?>
  </div>
  </form>
</body>
</html>