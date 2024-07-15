<?php
declare(strict_types=1);

final class Csrf
{
  public static function setToken(): void {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
  }

  public static function getToken(): string {
    return isset($_SESSION['csrf']) && is_string($_SESSION['csrf']) ? $_SESSION['csrf'] : '';
  }

  public static function validateToken(): void {
    $postToken = isset($_POST['csrf']) && is_string($_POST['csrf']) ? $_POST['csrf'] : '';
    $sessionToken = isset($_SESSION['csrf']) && is_string($_SESSION['csrf']) ? $_SESSION['csrf'] : '';

    if ($postToken === '' || $sessionToken === '' || $postToken !== $sessionToken) {
      header("Location: index.php");
      exit;
    }
  }

}