<?php
/**
 * Created by PhpStorm.
 * User: foreverzjz
 * Date: 2018/10/17
 * Time: 下午3:01
 */

namespace App\Controllers\Priv;

use App\Business\EventBusiness;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Bean\Annotation\Middlewares;
use App\Middlewares\AllowedMiddleware;


/**
 * Class EventController
 * @package App\Controllers\Priv
 * @Controller(prefix="/event")
 */
class EventController extends PrivControllerBase
{
    public function check(Request $request)
    {
        $request->input('name');
        return $request->url();
    }

    /**
     * @RequestMapping("record", method=RequestMethod::GET)
     */
    public function record(Request $request)
    {
        $bEvent = new EventBusiness();
        $result = $bEvent->statistic($request);
        if(false === $result){
            return $this->responseError();
        }
        return $this->responseData($result);
    }
}