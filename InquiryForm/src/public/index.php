<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>お問い合わせフォーム</title>
</head>
<body>
  <main>
    <h1>お問い合わせフォーム</h1>
    <form action="comfirm.php" method="post">
      <label for="name">名前</label><br>
      <input type="text" name="name" id="name"><br>
      <label for="email">メールアドレス</label><br>
      <input type="email" name="email" id="email"><br>
      <label for="message">お問い合わせ内容</label><br>
      <textarea name="message" id="message"></textarea><br>
      <input type="submit" value="送信">
    </form>
  </main>
</body>
</html>