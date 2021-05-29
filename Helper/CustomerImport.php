<?php
declare(strict_types = 1);

/**
 * @Author: Chandan Rai
 * @Creation Date:   2021-05-28 16:44:46
 * @Last Modified by:   Chandan Rai
 * @Last Modified time: 2021-05-28 20:36:25
 * @Email: chandan.rai@adapty.com
 * @Package: WundermanThompson_Import
 * @category: WundermanThompson
 * @copyright: Copyright (c) 2021 Wundermanthompson (http://www.wundermanthompson.com/)
 * @license: http://www.wundermanthompson.com/LICENSE-1.0.html
 */

namespace WundermanThompson\Import\Helper;

class CustomerImport
{
    /**
     * Logging instance
     * @var \WundermanThompson\Import\Logger\Logger
     */
    protected $_logger;

    protected $import;

    /**
     * CustomerImport constructor.
     * @param \WundermanThompson\Import\Logger\Logger $logger
     * @param \WundermanThompson\Import\Model\ImportCustomer $importCustomer
     */
    public function __construct(\WundermanThompson\Import\Logger\Logger $logger, \WundermanThompson\Import\Model\ImportCustomer $importCustomer)
    {
        $this->logger = $logger;
        $this->importCustomer = $importCustomer;
    }

    /**
     * Initiate the customer import job
     * @param $profilename
     * @param $profilepath
     *
     * @return void
     */
    public function execute($profilename, $profilepath)
    {

        $this
            ->logger
            ->addInfo("Customerjob Import Started.");
        switch ($profilename)
        {
            case 'sample-csv':
                $this
                    ->logger
                    ->addInfo("Customer CSV Import Started.");
                $this
                    ->importCustomer
                    ->run($profilename, $profilepath);
                $this
                    ->logger
                    ->addInfo("Customer CSV Import finished.");
            break;
            case 'sample-json':
                $this
                    ->logger
                    ->addInfo("Customer JSON Import Started.");
                $this
                    ->importCustomer
                    ->run($profilename, $profilepath);
                $this
                    ->logger
                    ->addInfo("Customer JSON finished.");
            break;
            case 'default':
                // Logging error in case of no profile mentioned while importing
                $this
                    ->logger
                    ->addInfo("Expected Import file not found");
        }

    }
}
