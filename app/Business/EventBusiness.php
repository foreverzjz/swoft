<?php
/**
 * Created by PhpStorm.
 * User: foreverzjz
 * Date: 2018/10/24
 * Time: 10:13 AM
 */

namespace App\Business;

use App\Core\Tools\ErrorHandler;
use App\Models\Entity\EventAction;
use App\Models\Entity\EventActionStatistics;
use Swoft\Db\Query;
use Swoft\Http\Message\Server\Request;

class EventBusiness
{
    //登录信息来源
    const LOGIN_SOURCE_APP = 1;
    const LOGIN_SOURCE_MC = 2;
    const LOGIN_SOURCE_MERCHANTS_SHOP = 3;
    const LOGIN_SOURCE_MERCHANTS_COMMERCIAL = 4;
    //请求来源
    const REQUEST_SOURCE_IOS = 1;
    const REQUEST_SOURCE_ANDROID = 2;
    const REQUEST_SOURCE_WECHAT = 3;
    const REQUEST_SOURCE_OTHER = 4;
    //行为类型
    const ACTION_TYPE_UNKNOWN = 0;

    public function statistic(Request $request)
    {
        $data = array();
        $requestUrl = urldecode($request->input('request_url'));
        //是否需要收集
        $checkAllow = $this->checkIsNeedCollect($requestUrl);
        if(!$checkAllow){
            return false;
        }
        $data['event_action_id'] = $checkAllow;

        //收集域名限制
        $tokenSource = $this->getTarget($requestUrl);
        if(!$tokenSource){
            return false;
        }

        //收集请求地址
        $data['request_url'] = $requestUrl;
        $requestParam = $request->input('request_params');
        //收集请求参数
        if(!empty($requestParam)){
            $data['request_params'] = $requestParam;
            $requestParam = json_decode($requestParam, true);
        }else{
            $data['request_params'] = [];
        }

        //收集请求来源
        if(!empty($requestParam['client_type']) && in_array($requestParam['client_type'], array(1, 2, 3))){
            $data['request_source'] = $requestParam['client_type'];
        }else{
            $data['request_source'] = self::REQUEST_SOURCE_OTHER;
        }

        //收集用户信息
        $requestDataParam = [];
        if(!empty($requestParam['data'])){
            $requestDataParam = json_decode(urldecode($requestParam['data']), true);
        }
        $loginInfo = $this->solveLoginToken($tokenSource, $requestParam, $requestDataParam);
        if($loginInfo){
            $data['token'] = $loginInfo['token'];
            $data['user_id'] = $loginInfo['user_id'];
        }

        //收集行为类型
        if(!empty($requestParam['action_type']) && in_array($requestParam['action_type'], array())){
            $data['action_type'] = $requestParam['action_type'];
        }else{
            $data['action_type'] = self::ACTION_TYPE_UNKNOWN;
        }

        //获取接口调用时间
        if(!empty($requestParam['request_time'])){
            $data['request_time'] = $requestParam['request_time'];
        }else{
            $data['request_time'] = date('Y-m-d H:i:s');
        }

        //获取接口返回结果
        if(!empty($requestParam['request_result'])){
            $data['request_result'] = $requestParam['request_result'];
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        return Query::table(EventActionStatistics::class)->insert($data)->getResult();
    }

    private function getTarget($url)
    {
        if(empty($url)){
            return false;
        }
        if(!preg_match('/^http/is', $url)){
            $url = 'http://'.$url;
        }
        $url = parse_url($url);
        $host = explode('.', $url['host'])[0];

        switch($host){
            case 'passport-v2':
            case 'passport-v3':
            case 'oc':
            case 'transport':
            case 'bsssvc':
                return self::LOGIN_SOURCE_APP;
                break;
            case 'manager-center':
                return self::LOGIN_SOURCE_MC;
                break;
            case 'merchants':
                if(empty($url['path'])){
                    return false;
                }
                $path = explode('/', $url['path']);
                if($path[0] === 'admin'){

                }else{
                    return self::LOGIN_SOURCE_APP;
                }
            default:
                return false;
                break;
        }
    }

    private function checkIsNeedCollect($url)
    {
        if(empty($url)){
            ErrorHandler::setErrorInfo("请求地址为空");
            return false;
        }
        $url = parse_url($url);
        if(empty($url['host']) || empty($url['path'])){
            ErrorHandler::setErrorInfo("错误的请求地址");
            return false;
        }
        $url = strtolower($url['host'] . $url['path']);
        $actionLists = EventAction::findAll()->getResult();
        if(empty($actionLists)){
            ErrorHandler::setErrorInfo("数据为空");
            return false;
        }

        foreach($actionLists as $key=>$value){
            if(empty($value['url'])) continue;
            $actionUrl = parse_url($value['url']);
            if(empty($actionUrl['host']) || empty($actionUrl['path'])){
                continue;
            }
            $auth = strtolower($actionUrl['host'] . $actionUrl['path']);
            if(strpos($auth, '$') !==  false){
                $pattern = '/' . str_replace('/', '#', $auth) . '/';
                $target = str_replace('/', '#', $url);
                preg_match($pattern, $target, $matches);
                if(count($matches) > 0){
                    return $value['id'];
                }
            }else{
                $auth = preg_replace('/\?.*$/U', '', $auth);
                if($auth == $url){
                    return $value['id'];
                }
            }
        }
        ErrorHandler::setErrorInfo("未匹配");
        return false;
    }

    private function solveLoginToken($source, $requestParam, $requestDataParam)
    {
        if(!empty($requestParam['login_token']) || !empty($requestParam['token']) || !empty($requestDataParam['login_token']) || !empty($requestDataParam['token'])){
            $loginToken = $requestParam['login_token'] ?? ($requestParam['token'] ?? ($requestDataParam['login_token'] ?? $requestDataParam['token']));
            switch($source){
                case self::LOGIN_SOURCE_APP:
                    break;
                case self::LOGIN_SOURCE_MC:
                    break;
                case self::LOGIN_SOURCE_MERCHANTS_SHOP:
                    break;
                case self::LOGIN_SOURCE_MERCHANTS_COMMERCIAL:
                    break;
            }
            $data['token'] = $loginToken;
            $data['user_id'] = 2876435;
            return $data;
        }else{
            return false;
        }
    }

    public function listForAdmin($query, $page = 1, $pageSize = 10)
    {
        $condition = ['is_delete'=>0];
        foreach($query as $key=>$value){
            if($value != ''){
                switch($key){
                    case 'title':
                    case 'url':
                        $condition[] = [$key, 'like', "%{$value}%"];
                        break;
                }
            }
        }
        $count = EventAction::count('id', $condition)->getResult();
        $list =  EventAction::findAll($condition, ['limit'=>$pageSize, 'offset'=>($page-1)*$pageSize])->getResult();
        return ['total'=>$count, 'list'=>$list, 'page'=>$page, 'page_size'=>$pageSize];
    }

    public function addAction($params)
    {
        if(empty($params['title'])){
            ErrorHandler::setErrorInfo("标题不能为空");
            return false;
        }
        if(empty($params['url'])){
            ErrorHandler::setErrorInfo("URL不能为空");
            return false;
        }

        $params['is_delete'] = 0;
        $params['created_at'] = date('Y-m-d H:i:s');
        $params['updated_at'] = $params['created_at'];
        $result = Query::table(EventAction::class)->insert($params)->getResult();
        if(!$result){
            ErrorHandler::setErrorInfo("存储失败");
            return false;
        }
        return true;
    }

    public function detailAction($eventActionId)
    {
        if(empty($eventActionId)){
            ErrorHandler::setErrorInfo("行为ID不能为空");
            return false;
        }

        $result = EventAction::findOne(['id'=>$eventActionId])->getResult();
        if(!$result){
            ErrorHandler::setErrorInfo("不存在的记录");
            return false;
        }
        return $result;
    }

    public function delAction($eventActionId)
    {
        if(empty($eventActionId)){
            ErrorHandler::setErrorInfo("行为ID不能为空");
            return false;
        }

        $result = EventAction::updateOne(['is_delete'=>1, 'deleted_at'=>date('Y-m-d H:i:s')], ['id'=>$eventActionId])->getResult();
        if(!$result){
            ErrorHandler::setErrorInfo("删除失败");
            return false;
        }
        return $result;
    }
}