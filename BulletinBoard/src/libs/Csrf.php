<?php
declare(strict_types=1);

require_once('Redirect.php');

final class Csrf
{
  public static function setToken(): void {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
  }

  public static function getPostToken() : string {
    return (isset($_POST['csrf']) && is_string($_POST['csrf'])) ? $_POST['csrf'] : '';
  }

  public static function getSessionToken() : string {
    return (isset($_SESSION['csrf']) && is_string($_SESSION['csrf'])) ? $_SESSION['csrf'] : '';
  }

  public static function validateToken(): void {
    $postToken = self::getPostToken();
    $sessionToken = self::getSessionToken();

    if ($postToken === '' || $sessionToken === '' || $postToken !== $sessionToken) {
      Redirect::redirectToIndex();
    }
  }

}