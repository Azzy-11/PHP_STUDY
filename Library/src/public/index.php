<?php
declare(strict_types=1);
session_start();

require_once('../libs/Request.php');
require_once('../libs/Csrf.php');
require_once('../libs/Validation.php');

$type = (isset($_POST['type']) && is_string($_POST['type'])) ? $_POST['type'] : "";
switch ($type) {
  case "101":
    Request::exceptPost();
    Csrf::checkToken();
    Validation::checkRegisterValidation();
    header("Location: comfirm.php");
    exit();
  
  default:
    # code...
    break;
}
?>