<?php
declare(strict_types=1);

final class Csrf
{
  public static function setToken() : void {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
  }

  public static function getPostToken() : string {
    return (isset($_POST['csrfToken']) && is_string($_POST['csrfToken'])) ? $_POST['csrfToken'] : "";
  }

  public static function getSessionToken() : string {
    return (isset($_SESSION['csrf']) && is_string($_SESSION['csrf'])) ? $_SESSION['csrf'] : "";
  }

  public static function isValid() : bool {
    $postToken = self::getPostToken();
    $sessionToken = self::getSessionToken();

    if ($postToken === "" || $sessionToken === "" || $postToken !== $sessionToken) {
      return false;
    }
    return true;
  }

  public static function checkToken() : void {
    if (self::isValid() === false) {
      // 403へ
      header("Location: regist.php");
      exit();
    }
  }
}
