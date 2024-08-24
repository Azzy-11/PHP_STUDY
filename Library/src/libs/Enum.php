<?php
declare(strict_types=1);

enum OperationMode : string  {
  case FromRegist = "101"; 
  case FromComfirm = "102"; 
  case FromAdminRegist= "103"; 
  case FromAdminComfirm = "104"; 
  case Login = "201"; 
  case Logout = "202"; 
}
