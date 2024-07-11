<?php
declare(strict_types=1);

final class Request
{
  private const POST = "POST";

  public static function isPost(): bool {
    return $_SERVER["REQUEST_METHOD"] === self::POST;
  }

  public static function redirectToIndexUnlessPost():void {
    if (!self::isPost()) {
      header("Location: index.php");
      exit;
    }
  }
}