<?php
declare(strict_types=1);

final class Redirect
{
  private const LOGIN = "login";
  private const REGIST = "regist";
  private const COMFIRM = "comfirm";
  private const TOP = "top";

  public static function redirectTo(string $location) : void {
    $path = self::getUrl($location);
    header("Location: $path");
    exit();
  }

  public static function getUrl(string $location) : string {
    switch ($location) {
      case self::LOGIN:
        return "login.php";
      
      case self::REGIST:
        return "regist.php";

      case self::COMFIRM:
        return "comfirm.php";

      case self::TOP:
        return "top.php";
      
      default:
        return "login.php";
    }
  }
}