<?php
declare(strict_types=1);

final class Validation
{
  private const name = 'name';
  private const email = 'email';
  private const password = 'password';
  private const jaName = "名前";
  private const jaEmail = "メールアドレス";
  private const jaPassword = "パスワード";
  private const regName = "/^.{1,16}$/";
  private const regEmail = "/^(?=.{1,255}$)(?=.{1,64}@)[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,}$/";
  private const regPassword = "/^[a-zA-Z0-9.?\/\-!@]{8,24}$/";

  public static function checkRegisterValidation() : void {
    $name = self::getName();
    $email = self::getEmail();
    $password = self::getPassword();

    self::validate(self::name, self::regName, $name, self::jaName);
    self::validate(self::email, self::regEmail, $email, self::jaEmail);
    self::validatePassword();
    if (self::hasError()) {
      header("Location: regist.php");
      exit();
    }

    $_SESSION['formData']['name'] = $name;
    $_SESSION['formData']['email'] = $email;
    $_SESSION['formData']['password'] = $password;
  }

  public static function validate($name, $reg, $element, $flash) : void {
    if (self::isRegexMismatch($reg, $element)) {
      $_SESSION['flash'][$name] = $flash . "を正しく入力してください";
    }
    if (self::isEmpty($element)) {
      $_SESSION['flash'][$name] = $flash . "を入力してください";
    }
    self::setOriginal($name, $element);
  }

  public static function validatePassword() : void {
    $password = self::getPassword();
    $rePassword = self::getRePassword();
    self::validate(self::password, self::regPassword, $password, self::jaPassword);
    if (self::isEmpty($rePassword) || self::isUnequal($password, $rePassword)) {
      $_SESSION['flash']['re:password'] = "パスワードが一致しません";
    }
    self::setOriginal(self::password, $password);
  }

  public static function setOriginal($name, $element) : void {
    $_SESSION['original'][$name] = $element;
  }

  public static function getName() : string {
    return (isset($_POST['name']) && is_string($_POST['name'])) ? $_POST['name'] : "";
  }

  public static function getEmail() : string {
    return (isset($_POST['email']) && is_string($_POST['email'])) ? $_POST['email'] : "";
  }

  public static function getPassword() : string {
    return (isset($_POST['password']) && is_string($_POST['password'])) ? $_POST['password'] : "";
  }

  public static function getRePassword() : string {
    return (isset($_POST['re:password']) && is_string($_POST['re:password'])) ? $_POST['re:password'] : "";
  }

  public static function isRegexMismatch($reg, $element) : bool {
    return preg_match($reg, $element) === 0;
  }

  public static function isEmpty($element) : bool {
    return empty($element);
  }

  public static function isUnequal($element1, $element2) : bool {
    return $element1 !== $element2;
  }

  public static function hasError() : bool {
    return isset($_SESSION['flash']);
  }

  public static function setErrorParam() : array {
    $flash = isset($_SESSION['flash']) ? $_SESSION['flash'] : null;
    $original = isset($_SESSION['original']) ? $_SESSION['original'] : null;
    unset($_SESSION['flash'], $_SESSION['original']);
    
    return [
      $flash,
      $original,
    ];
  }
}