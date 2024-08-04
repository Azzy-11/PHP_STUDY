<?php
declare(strict_types=1);

final class Request
{
  private const POST = "POST";

  public static function isPost() : bool {
    return $_SERVER['REQUEST_METHOD'] === self::POST;
  }

  public static function exceptPost() : void {
    if (self::isPost() === false) {
      //403へ
      header("Location: regist.php");
      exit();
    }
  }
}