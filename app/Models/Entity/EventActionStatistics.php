<?php
namespace App\Models\Entity;

use Swoft\Db\Model;
use Swoft\Db\Bean\Annotation\Column;
use Swoft\Db\Bean\Annotation\Entity;
use Swoft\Db\Bean\Annotation\Id;
use Swoft\Db\Bean\Annotation\Required;
use Swoft\Db\Bean\Annotation\Table;
use Swoft\Db\Types;

/**
 * @Entity()
 * @Table(name="event_action_statistics")
 * @uses      EventActionStatistics
 */
class EventActionStatistics extends Model
{
    /**
     * @var int $id 自增ID
     * @Id()
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var int $userId 用户ID
     * @Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string $token 用户登录token
     * @Column(name="token", type="string", length=32)
     */
    private $token;

    /**
     * @var int $userType 用户类型
     * @Column(name="user_type", type="tinyint")
     */
    private $userType;

    /**
     * @var int $actionType 行为类型
     * @Column(name="action_type", type="tinyint")
     */
    private $actionType;

    /**
     * @var string $requestUrl 请求url
     * @Column(name="request_url", type="string", length=255)
     * @Required()
     */
    private $requestUrl;

    /**
     * @var string $requestParams 请求参数
     * @Column(name="request_params", type="text", length=65535)
     * @Required()
     */
    private $requestParams;

    /**
     * @var int $requestSource 请求来源
     * @Column(name="request_source", type="tinyint")
     * @Required()
     */
    private $requestSource;

    /**
     * @var string $requestResult 
     * @Column(name="request_result", type="text", length=65535)
     */
    private $requestResult;

    /**
     * @var string $requestTime 请求时间
     * @Column(name="request_time", type="datetime")
     * @Required()
     */
    private $requestTime;

    /**
     * @var string $createdAt 创建时间
     * @Column(name="created_at", type="datetime")
     * @Required()
     */
    private $createdAt;

    /**
     * 自增ID
     * @param int $value
     * @return $this
     */
    public function setId(int $value)
    {
        $this->id = $value;

        return $this;
    }

    /**
     * 用户ID
     * @param int $value
     * @return $this
     */
    public function setUserId(int $value): self
    {
        $this->userId = $value;

        return $this;
    }

    /**
     * 用户登录token
     * @param string $value
     * @return $this
     */
    public function setToken(string $value): self
    {
        $this->token = $value;

        return $this;
    }

    /**
     * 用户类型
     * @param int $value
     * @return $this
     */
    public function setUserType(int $value): self
    {
        $this->userType = $value;

        return $this;
    }

    /**
     * 行为类型
     * @param int $value
     * @return $this
     */
    public function setActionType(int $value): self
    {
        $this->actionType = $value;

        return $this;
    }

    /**
     * 请求url
     * @param string $value
     * @return $this
     */
    public function setRequestUrl(string $value): self
    {
        $this->requestUrl = $value;

        return $this;
    }

    /**
     * 请求参数
     * @param string $value
     * @return $this
     */
    public function setRequestParams(string $value): self
    {
        $this->requestParams = $value;

        return $this;
    }

    /**
     * 请求来源
     * @param int $value
     * @return $this
     */
    public function setRequestSource(int $value): self
    {
        $this->requestSource = $value;

        return $this;
    }

    /**
     * @param string $value
     * @return $this
     */
    public function setRequestResult(string $value): self
    {
        $this->requestResult = $value;

        return $this;
    }

    /**
     * 请求时间
     * @param string $value
     * @return $this
     */
    public function setRequestTime(string $value): self
    {
        $this->requestTime = $value;

        return $this;
    }

    /**
     * 创建时间
     * @param string $value
     * @return $this
     */
    public function setCreatedAt(string $value): self
    {
        $this->createdAt = $value;

        return $this;
    }

    /**
     * 自增ID
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 用户ID
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * 用户登录token
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 用户类型
     * @return int
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * 行为类型
     * @return int
     */
    public function getActionType()
    {
        return $this->actionType;
    }

    /**
     * 请求url
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->requestUrl;
    }

    /**
     * 请求参数
     * @return string
     */
    public function getRequestParams()
    {
        return $this->requestParams;
    }

    /**
     * 请求来源
     * @return int
     */
    public function getRequestSource()
    {
        return $this->requestSource;
    }

    /**
     * @return string
     */
    public function getRequestResult()
    {
        return $this->requestResult;
    }

    /**
     * 请求时间
     * @return string
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * 创建时间
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}
