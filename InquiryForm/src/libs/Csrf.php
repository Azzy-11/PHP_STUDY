<?php
declare(strict_types=1);

final class Csrf
{
  public static function setToken(): void {
    $_SESSION['csrfToken'] = bin2hex(random_bytes(16));
  }

  public static function getToken(): string {
    return isset($_SESSION['csrfToken']) ? $_SESSION['csrfToken'] : '';
  }

  public static function validateToken(): void {
    $postToken = isset($_POST["csrfToken"]) && is_string($_POST["csrfToken"]) ? $_POST["csrfToken"] : '';
    $sessionToken = isset($_SESSION['csrfToken']) ? $_SESSION['csrfToken'] : '';
    if ($postToken === "" || $sessionToken === "" || $postToken !== $sessionToken) {
      header("Location: index.php");
      exit;
    } ;
  }
}