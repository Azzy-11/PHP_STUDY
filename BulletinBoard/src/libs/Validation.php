<?php
declare(strict_types=1);

require_once('Redirect.php');

final class Validation
{

  public static function validation() : array {
    $name = isset($_POST["name"]) && is_string($_POST["name"]) ? $_POST["name"] : "";
    $content = isset($_POST["content"]) && is_string($_POST["content"]) ? $_POST["content"] : "";

    self::validateName($name);
    self::validateContent($content);

    if (self::hasErrors()) {
      Redirect::redirectToIndex();
    }

    return [
      $name,
      $content
    ];
  }

  public static function validateName($name): void {
    if ($name === "") {
      $_SESSION['flash']['name'] = "投稿者名を入力してください";
    }
    if (mb_strlen($name) > 17) {
      $_SESSION['flash']['name'] = "投稿者名を16文字以内で入力してください";
    }
    $_SESSION['original']['name'] = $name;
  }

  public static function validateContent($content): void {
    if ($content === "") {
      $_SESSION['flash']['content'] = "投稿内容を入力してください";
    }
    if (mb_strlen($content) > 301) {
      $_SESSION['flash']['content'] = "投稿内容を300文字以内で入力してください";
    }
    $_SESSION['original']['content'] = $content;
  }

  private static function hasErrors(): bool
  {
      return isset($_SESSION['flash']['name']) || isset($_SESSION['flash']['content']) || isset($_SESSION['flash']['message']);
  }

  public static function setValidatedErrorParam(): array {
    $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
    $original = isset($_SESSION['original']) ? $_SESSION['original'] : null;
    unset($_SESSION['flash'], $_SESSION['original']);
    
    return [
      $flash,
      $original,
    ];
  }
}