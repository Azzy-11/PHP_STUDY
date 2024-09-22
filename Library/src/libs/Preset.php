<?php
declare(strict_types=1);

class Preset {
  public static function getUserId() : int {
    return (isset($_SESSION['user']['id']) && is_int($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : "";
  }

  public static function getUserName() : string {
    return (isset($_SESSION['user']['name']) && is_string($_SESSION['user']['name'])) ? $_SESSION['user']['name'] : "";
  }
}