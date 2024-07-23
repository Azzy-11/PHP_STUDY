<?php
declare(strict_types=1);

final class Redirect {

  public static function redirectToIndex() : void
  {
    header("Location: index.php");
    exit();
  }
}

