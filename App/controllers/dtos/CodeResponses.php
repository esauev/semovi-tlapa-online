<?php
namespace App\controllers\dtos;

defined("APPPATH") OR die("Access denied");

class CodeResponses {
    static $OK = 0;
    static $OK_MESSAGE = "success";

    static $BD_ERROR_INSERT = 1;
    static $BD_ERROR_INSERT_MESSAGE = "error when try insert";

    static $BD_ERROR_DELETE = 2;
    static $BD_ERROR_DELETE_MESSAGE = "error when try delete";

    static $BD_ERROR_UPDATE = 3;
    static $BD_ERROR_UPDATE_MESSAGE = "error when try update";

    static $ERROR_SESSION = 4;
    static $ERROR_SESSION_MESSAGE = "error with session";

    static $ERROR_USER_EXIST = 5;
    static $ERROR_USER_EXIST_MESSAGE = "error this user exist in database";

    static $ERROR_SESSION_LOGIN = 401;
    static $ERROR_SESSION_LOGIN_MESSAGE = "Unauthorized";

    static $ERROR_GENERAL = 500;
    static $ERROR_GENERAL_MESSAGE = "eroor unknow";
}