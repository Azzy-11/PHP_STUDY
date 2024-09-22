<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/dbConnect.php');
require_once('../libs/History.php');
require_once('../libs/Auth.php');
require_once('../libs/Preset.php');

Auth::checkAuth();
if (Request::isGet()) {
  $select = new History($db);
  $histories = $select->read(Preset::getUserId());
}
Csrf::setToken();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>マイページ | Library</title>
  <script>
    function sendBookId(id) {
      document.getElementById('bookId').value = id;
      document.getElementById('rentalForm').submit();
    }
  </script>
</head>
<body>
  <h1><?php echo Preset::getUserName(); ?>さんのマイページ</h1>
  <form id="rentalForm" action="book.php" method="post">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" name="bookId" id="bookId" value="">
    <input type="hidden" name="type" value="402">
  </form>
  <h2>レンタル履歴</h2>
  <table>
    <tr>
      <th>書籍番号</th>
      <th>書籍タイトル</th>
      <th>レンタル日</th>
      <th>返却日</th>
    </tr>
    
    <?php foreach ($histories as $key => $history): ?>
      <?php
      $bookId = htmlspecialchars($history['book_id'], ENT_QUOTES);
      $bookTtl = htmlspecialchars($history['book_title'], ENT_QUOTES);
      $borrowedAt = htmlspecialchars($history['created_at'], ENT_QUOTES);
      $updatedAt = htmlspecialchars($history['updated_at'], ENT_QUOTES);
      ?>

      <tr>
        <td><?php echo $bookId; ?></td>
        <td><?php echo $bookTtl; ?></td>
        <td><?php echo $borrowedAt; ?></td>
        <?php if($borrowedAt === $updatedAt): ?>
          <td>
            <button type='button' onclick='sendBookId("<?php echo $bookId; ?>")'>返却</button>
          </td>

        <?php elseif($borrowedAt < $updatedAt): ?>
          <td><?php echo $updatedAt; ?></td>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
  </table>
  <a href="top.php">トップページ</a>
</body>
</html>