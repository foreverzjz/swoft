<?php
/**
 * Created by PhpStorm.
 * User: foreverzjz
 * Date: 2018/11/1
 * Time: 10:24 AM
 */

namespace App\Controllers\Admin;

use App\Business\EventBusiness;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Bean\Annotation\Middlewares;
use App\Middlewares\InitializeMiddleware;


/**
 * Class EventController
 * @package App\Controllers\Priv
 * @Controller(prefix="/admin/event")
 * @Middleware(InitializeMiddleware::class)
 */
class EventController extends AdminControllerBase
{
    /**
     * @RequestMapping("list", method=RequestMethod::GET)
     */
    public function list(Request $request)
    {
        $page = $request->input('page');
        if(empty($page) || !is_numeric($page) || $page <= 0){
            $page = 1;
        }

        $pageSize = $request->input('page_size');
        if(empty($pageSize) || !is_numeric($pageSize) || $pageSize <= 0){
            $pageSize = 10;
        }

        $queryParam = [
            'title'=>$request->input('title') ?? '',
            'url'=>$request->input('url') ?? ''
        ];

        $bEvent = new EventBusiness();
        $result = $bEvent->listForAdmin($queryParam, $page, $pageSize);
        if($result === false){
            return $this->responseError('获取事件行为失败');
        }
        return $this->responseData($result);
    }

    /**
     * @RequestMapping("add", method=RequestMethod::POST)
     */
    public function add(Request $request)
    {
        $params = $request->input();

        $bEvent = new EventBusiness();
        $result = $bEvent->addAction($params);
        if($result === false){
            return $this->responseError();
        }
        return $this->responseData($result);
    }

    /**
     * @RequestMapping("detail", method=RequestMethod::GET)
     */
    public function detail(Request $request)
    {
        $eventActionId = $request->input('event_action_id');

        $bEvent = new EventBusiness();
        $result = $bEvent->detailAction($eventActionId);
        if($result === false){
            return $this->responseError();
        }
        return $this->responseData($result);
    }

    /**
     * @RequestMapping("delete", method=RequestMethod::POST)
     */
    public function delete(Request $request)
    {
        $eventActionId = $request->input('event_action_id');

        $bEvent = new EventBusiness();
        $result = $bEvent->delAction($eventActionId);
        if($result === false){
            return $this->responseError();
        }
        return $this->responseData($result);
    }
}