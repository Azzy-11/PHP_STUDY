<?php
declare(strict_types=1);

require_once('Redirect.php');

final class Validation
{
  private const name = 'name';
  private const email = 'email';
  private const password = 'password';
  private const bookTtl = 'bookTitle';
  private const jaName = "名前";
  private const jaEmail = "メールアドレス";
  private const jaPassword = "パスワード";
  private const jaBookTtl = "書籍タイトル";
  private const regName = "/^.{1,16}$/";
  private const regEmail = "/^(?=.{1,255}$)(?=.{1,64}@)[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.[a-zA-Z]{2,}$/";
  private const regPassword = "/^[a-zA-Z0-9.?\/\-!@]{8,24}$/";
  private const regBookTtl = "/^.{1,32}$/";

  
  /**
   * 会員登録
   */
  public static function checkRegisterValidation() : array {
    $name = self::getName();
    $email = self::getEmail();
    $password = self::getPassword();
    $rePassword = self::getRePassword();

    self::validate(self::name, self::regName, $name, self::jaName);
    self::validate(self::email, self::regEmail, $email, self::jaEmail);
    self::validatePassword();
    if (self::hasError()) {
      Redirect::redirectTo("regist");
    }

    return [
      $name,
      $email,
      $password,
      $rePassword
    ];
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
  
  /**
   * 書籍登録
   */
  public static function checkRegBookValidation() : string {
    $bookTtl = self::getBookTtl();
    self::validate(self::bookTtl, self::regBookTtl, $bookTtl, self::jaBookTtl);
    if (self::hasError()) {
      Redirect::redirectTo("regBook");
    }

    return $bookTtl;
  }
  
  public static function getBookTtl() : string {
    return (isset($_POST['bookTitle']) && is_string($_POST['bookTitle'])) ? $_POST['bookTitle'] : "";
  }

  /**
   * 書籍レンタル
   */
  public static function checkRentBookValidation() : string {
    $bookId = self::getBookId();
    if (self::isEmpty($bookId)) {
      Redirect::redirectTo('bookList');
    }
    return $bookId;
  }

  public static function checkReturnBookValidation() : int {
    $historyId = self::getHistoryId();
    if (self::isEmpty($historyId)) {
      Redirect::redirectTo('bookList');
    }
    return (int)$historyId;
  }
  
  public static function getBookId() : string {
    return (isset($_POST['bookId']) && is_string($_POST['bookId'])) ? $_POST['bookId'] : "";
  }

  public static function getHistoryId() : string {
    return (isset($_POST['historyId']) && is_string($_POST['historyId'])) ? $_POST['historyId'] : "";
  }

  /**
   * 共通
   */
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

  public static function validate($name, $reg, $element, $flash) : void {
    if (self::isRegexMismatch($reg, $element)) {
      $_SESSION['flash'][$name] = $flash . "を正しく入力してください";
    }
    if (self::isEmpty($element)) {
      $_SESSION['flash'][$name] = $flash . "を入力してください";
    }
    self::setOriginal($name, $element);
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