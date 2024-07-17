<?php
declare(strict_types=1);

final class REQUEST
{
  private const GET = "GET";
  private const POST = "POST";

  public static function isGet(): bool {
    return $_SERVER['REQUEST_METHOD'] === self::GET;
  }

  public static function isPost(): bool {
    return $_SERVER['REQUEST_METHOD'] === self::POST;
  }

  public static function isFirstRequest(): bool {
    return !isset($_SESSION['csrf']);
  }

  public static function exceptGetAndPost(): void {
    if (!self::isGet() && !self::isPost()) {
      header("Location: index.php");
      exit;
    }
  }

  public static function exceptPost(): void {
    if (!self::isPost()) {
      header("Location: index.php");
      exit;
    }
  }
}
