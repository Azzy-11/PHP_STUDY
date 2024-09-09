<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/dbConnect.php');
require_once('../libs/Book.php');

if (Request::isGet()) {
  $select = new Book($db);
  $books = $select->read();
}
Csrf::setToken();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>書籍一覧 | Library</title>
  <script>
    function sendBookId(id) {
      document.getElementById('bookId').value = id;
      document.getElementById('rentalForm').submit();
    }
  </script>
</head>
<body>
  <h1>書籍一覧</h1>
  <form id="rentalForm" action="book.php" method="post">
    <input type="hidden" name="csrfToken" value="<?php echo $_SESSION['csrf']; ?>">
    <input type="hidden" name="bookId" id="bookId" value="">
    <input type="hidden" name="type" value="401">
  </form>
  <table>
    <tr>
      <th>書籍番号</th>
      <th>書籍タイトル</th>
      <th>ステータス</th>
      <th>レンタル</th>
    </tr>
    
    <?php foreach ($books as $key => $book): ?>
      <?php
      $bookId = htmlspecialchars($book['id'], ENT_QUOTES);
      $bookTtl = htmlspecialchars($book['book_title'], ENT_QUOTES);
      $bookStatus = isset($book['borrowed_at']) ? "レンタル中" : "レンタル可";
      ?>

      <tr>
        <td><?php echo $bookId; ?></td>
        <td><?php echo $bookTtl; ?></td>
        <td><?php echo $bookStatus; ?></td>
        <td>
          <button type='button' onclick='sendBookId("<?php echo $bookId; ?>")'>選択</button>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</body>
</html>
