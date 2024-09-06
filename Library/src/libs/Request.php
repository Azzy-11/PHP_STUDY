<?php
declare(strict_types=1);

require_once('Redirect.php');

final class Request
{
  private const POST = "POST";
  private const GET = "GET";

  public static function isPost() : bool {
    return $_SERVER['REQUEST_METHOD'] === self::POST;
  }

  public static function isGet() : bool {
    return $_SERVER['REQUEST_METHOD'] === self::GET;
  }

  public static function exceptPost() : void {
    if (self::isPost() === false) {
      //403へ
      Redirect::redirectTo("login.php");
    }
  }
}