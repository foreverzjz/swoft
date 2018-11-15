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
 * @Table(name="event_action")
 * @uses      EventAction
 */
class EventAction extends Model
{
    /**
     * @var int $id 主键ID
     * @Id()
     * @Column(name="id", type="integer")
     */
    private $id;

    /**
     * @var string $title 接口名称
     * @Column(name="title", type="string", length=255)
     * @Required()
     */
    private $title;

    /**
     * @var string $url 接口地址
     * @Column(name="url", type="string", length=255)
     * @Required()
     */
    private $url;

    /**
     * @var string $description 接口描述
     * @Column(name="description", type="text", length=65535)
     */
    private $description;

    /**
     * @var string $createdAt 创建时间
     * @Column(name="created_at", type="datetime")
     * @Required()
     */
    private $createdAt;

    /**
     * @var string $updatedAt 更新时间
     * @Column(name="updated_at", type="datetime")
     * @Required()
     */
    private $updatedAt;

    /**
     * @var string $deletedAt 删除时间
     * @Column(name="deleted_at", type="datetime")
     */
    private $deletedAt;

    /**
     * 主键ID
     * @param int $value
     * @return $this
     */
    public function setId(int $value)
    {
        $this->id = $value;

        return $this;
    }

    /**
     * 接口名称
     * @param string $value
     * @return $this
     */
    public function setTitle(string $value): self
    {
        $this->title = $value;

        return $this;
    }

    /**
     * 接口地址
     * @param string $value
     * @return $this
     */
    public function setUrl(string $value): self
    {
        $this->url = $value;

        return $this;
    }

    /**
     * 接口描述
     * @param string $value
     * @return $this
     */
    public function setDescription(string $value): self
    {
        $this->description = $value;

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
     * 更新时间
     * @param string $value
     * @return $this
     */
    public function setUpdatedAt(string $value): self
    {
        $this->updatedAt = $value;

        return $this;
    }

    /**
     * 删除时间
     * @param string $value
     * @return $this
     */
    public function setDeletedAt(string $value): self
    {
        $this->deletedAt = $value;

        return $this;
    }

    /**
     * 主键ID
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 接口名称
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * 接口地址
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * 接口描述
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * 创建时间
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * 更新时间
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * 删除时间
     * @return string
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

}
