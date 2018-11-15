<?php
/**
 * Created by PhpStorm.
 * User: foreverzjz
 * Date: 2018/10/24
 * Time: 10:43 AM
 */

namespace App\Core\Base;


use App\Core\Tools\ErrorHandler;

class Controller
{
    public function responseError(string $message = '', int $flag = -1)
    {
        if(empty($message) && !empty(ErrorHandler::$message)){
            $message = ErrorHandler::$message;
        }
        if($flag == -1 && ErrorHandler::$flag < 0){
            $flag = ErrorHandler::$flag;
        }

        $return = array();

        $return['result'] = false;
        $return['message'] = $message;
        $return['flag'] = $flag;
        return $return;
    }

    public function responseData($data = [], int $flag = 1)
    {
        $return = array();

        $return['result'] = true;
        $return['data'] = $data;
        $return['flag'] = $flag;
        $return['message'] = 'Success';
        return $return;
    }
}