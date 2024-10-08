<?php
declare(strict_types=1);

require_once('Redirect.php');

class Auth
{
  public function __construct(private PDO $db)
  {
  }

  public function checkCredentials() :  void {
    $loginId = self::getLoginId();
    $loginPw = self::getLoginPw();
    try {
      $read = $this->db->prepare("SELECT id, password, name, admin FROM users WHERE email = :loginId AND deleted_at IS NULL");
      $read->bindValue(':loginId', $loginId, PDO::PARAM_STR);
      $read->execute();
      $user = $read->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      throw new Exception("Database Error: " . $e->getMessage());
    }

    if (empty($user) || count($user) > 1) {
      Redirect::redirectTo("login");
    }

    $userPw = $user[0]["password"];
    if (password_verify($loginPw, $userPw)) {
      $_SESSION['user'] = [
        'status' => 1,
        'id' => $user[0]["id"],
        'name' => $user[0]["name"],
        'email' => $loginId,
        'admin' => $user[0]["admin"]
      ];
      session_regenerate_id(true);
      Redirect::redirectTo("top");

    } else {
      Redirect::redirectTo("login");
    }
  }

  public static function checkAuth() : void {
    if (self::isLoggedIn() === false) {
      self::logout();
    }
  }
  
  public function getLoginId() : string {
    return (isset($_POST['loginId']) && is_string($_POST['loginId'])) ? $_POST['loginId'] : "";
  }
  
  public function getLoginPw() : string {
    return (isset($_POST['loginPw']) && is_string($_POST['loginPw'])) ? $_POST['loginPw'] : "";
  }
  
  public static function getLoginStatus() : int {
    return (isset($_SESSION['user']['status']) && is_int($_SESSION['user']['status'])) ? $_SESSION['user']['status'] : 0;
  }
  
  public static function isLoggedIn() : bool {
    return self::getLoginStatus() === 1;
  }
  
  public static function logout() : void {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
    }
    session_destroy();
    Redirect::redirectTo("login");
  }
}