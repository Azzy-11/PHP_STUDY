<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');
require_once('../libs/dbConnect.php');
require_once('../libs/Post.php');

Request::exceptGetAndPost();
Csrf::setToken();

[$flash, $original] = Validation::setValidatedErrorParam();

$readPost = new Post($db, null, null, null);
$posts =$readPost->findPost();

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
  <form action="insert.php" method="post">
    <label for="text">投稿者名</label><br>
    <input type="text" name="name" id="name" value="<?php echo isset($original['name']) ? $original['name'] : ''; ?>"><br>
    <?php echo isset($flash['name']) ? '<p>' . $flash['name'] . '</p>' : '';; ?>
    <label for="content">投稿内容</label><br>
    <textarea name="content" id="content"><?php echo isset($original['content']) ? $original['content'] : '';; ?></textarea><br>
    <?php echo isset($flash['content']) ? '<p>' . $flash['content'] . '</p>' : '';; ?>
    <input type="hidden" name="csrf" value="<?php echo Csrf::getSessionToken(); ?>">
    <button type="submit">投稿</button>
  </form>

  <hr>
  <div>
    <?php foreach ($posts as $post): ?>
      <?php
      $postId = htmlspecialchars((string)$post['id'], ENT_QUOTES);
      $postName = htmlspecialchars($post['name'], ENT_QUOTES);
      $postContent = htmlspecialchars($post['content'], ENT_QUOTES);
      $postTime = htmlspecialchars($post['updated_at'], ENT_QUOTES);
      ?>

      <p>
        <?php echo $postContent; ?> | <?php echo $postName; ?> | <?php echo $postTime; ?> | 
        <form action="delete.php" method="post" onsubmit="return confirm('本当に削除しますか？');">
          <input type="hidden" name="postId" value="<?php echo $postId; ?>">
          <input type="hidden" name="csrf" value="<?php echo Csrf::getSessionToken(); ?>">
          <button type="submit">削除</button>
        </form>
      </p>

    <?php endforeach; ?>
  </div>
  </form>
</body>
</html>