<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
namespace SwoftTest\Db\Testing\Pool;

use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Pool;
use Swoft\Db\Pool\DbPool;

/**
 * OtherDbPool
 *
 * @Pool("idle.master")
 */
class MaxIdleTimeDbPool extends DbPool
{
    /**
     * @Inject()
     * @var MaxIdleTimeDbConfig
     */
    protected $poolConfig;
}
