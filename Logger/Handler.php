<?php
declare(strict_types=1);

/**
 * @Author: Chandan Rai
 * @Creation Date:   2021-05-28 17:34:46
 * @Last Modified by:   Chandan Rai
 * @Last Modified time: 2021-05-28 20:36:25
 * @Email: chandan.rai@adapty.com
 * @Package: WundermanThompson_Import
 * @category: WundermanThompson
 * @copyright: Copyright (c) 2021 Wundermanthompson (http://www.wundermanthompson.com/)
 * @license: http://www.wundermanthompson.com/LICENSE-1.0.html
 */


namespace WundermanThompson\Import\Logger;

use Monolog\Logger;

class Handler extends \Magento\Framework\Logger\Handler\Base
{
    /**
     * Logging level
     * @var int
     */

    protected $loggerType = Logger::DEBUG;

    /**
        * Class add exception to custom logger file instead of magento custom exception log
        * @var string
     */
    protected $fileName = '/var/log/wunderman-thompson-import.log';
}
