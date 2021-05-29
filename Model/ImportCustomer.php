<?php
declare(strict_types = 1);

/**
 * @Author: Chandan Rai
 * @Creation Date:   2021-05-28 18:00:46
 * @Last Modified by:   Chandan Rai
 * @Last Modified time: 2021-05-28 18:36:25
 * @Email: chandan.rai@adapty.com
 * @Package: WundermanThompson_Import
 * @category: WundermanThompson
 * @copyright: Copyright (c) 2021 Wundermanthompson (http://www.wundermanthompson.com/)
 * @license: http://www.wundermanthompson.com/LICENSE-1.0.html
 */

namespace WundermanThompson\Import\Model;

use Magento\Framework\App\Helper\AbstractHelper;

class ImportCustomer extends AbstractHelper
{
    protected $website;

    protected $storeManager;

    protected $customerData;

    protected $customerRepository;

    protected $state;

    /**
     * Import constructor.
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Customer\Api\Data\CustomerInterface $customerData
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository
     * @param \Magento\Framework\App\State $state
     */
    public function __construct(\Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Customer\Api\Data\CustomerInterface $customerData, \Magento\Customer\Api\CustomerRepositoryInterface $customerRepository, \Magento\Framework\App\State $state, \Magento\Framework\Filesystem\DirectoryList $directoryList, \Magento\Customer\Model\CustomerFactory $customerFactory)
    {
        $this->storeManager = $storeManager;
        $this->customerData = $customerData;
        $this->customerRepository = $customerRepository;
        $this->state = $state;
        $this->directoryList = $directoryList;
        $this->customerFactory = $customerFactory;
    }

    /**
     * Get Default website ID
     * @return string|int
     */
    public function getDefaultWebsiteId()
    {
        return $this
            ->storeManager
            ->getDefaultStoreView()
            ->getWebsiteId();
    }

    /**
     * Run Customer import command based on type of file import
     * @param $profilename
     * @param $profilepath
     */
    public function run($profilename, $profilepath)
    {
        try
        {
            $this
                ->state
                ->setAreaCode(\Magento\Framework\App\Area::AREA_ADMINHTML);
        }
        catch(\Exception $e)
        {
            throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
        }
        if ($profilename == 'sample-json')
        {
            $this->parseCustomerJson($profilepath);
        }
        else
        {
            $this->parseCustomerCsv($profilepath);
        }
    }

    /**
     * Parse Customer import JSON and save/update to customer object
     * @param $profilename
     */
    public function parseCustomerJson($profilepath)
    {

        $jsonFile = $this
            ->directoryList
            ->getPath('var') . "/import/" . $profilepath;

        if ($jsonFile !== false)
        {

            $jsonfileContent = file_get_contents($jsonFile); /* read JSON content */
            $jsonToArray = json_decode($jsonfileContent, true); /* convert JSON to Array for further processing*/
            foreach ($jsonToArray as $value)
            {
                $email = $value['emailaddress'];

                $customerData = $this->customerData;

                $websiteId = $this->getDefaultWebsiteId();
                $customerObj = $this
                    ->customerFactory
                    ->create()
                    ->setWebsiteId($websiteId);
                $customer = $customerObj->loadByEmail($value['emailaddress']);
                try
                {
                    $customer->setFirstname($value['fname'])->setWebsiteId($websiteId)->setLastname($value['lname'])->setEmail($value['emailaddress']);

                    $customAttribute = $customer->getDataModel();
                    $customer->updateData($customAttribute);
                    $customer->save();
                }
                catch(\Exception $e)
                {
                    throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
                }
            }
        }
    }

    /**
     * Parse Customer import CSV and save/update to customer object
     * @param $profilename
     */

    public function parseCustomerCsv($profilepath)
    {

        $csvFile = fopen("var/import/" . $profilepath, "r"); // set path to the JSON file
        if ($csvFile !== false)
        {
            $header = fgetcsv($csvFile); // get data headers and skip 1st row
            while ($row = fgetcsv($csvFile, 3000, ","))
            {
                $data_count = count($row);
                if ($data_count < 1)
                {
                    continue;
                }

                $customerArr = [];
                $customerArr = array_combine($header, $row);
                $email = $customerArr['emailaddress'];

                $customerData = $this->customerData;

                $websiteId = $this->getDefaultWebsiteId();
                $customerObj = $this
                    ->customerFactory
                    ->create()
                    ->setWebsiteId($websiteId);
                $customer = $customerObj->loadByEmail($customerArr['emailaddress']);
                try
                {
                    $customer->setFirstname($customerArr['fname'])->setWebsiteId($websiteId)->setLastname($customerArr['lname'])->setEmail($customerArr['emailaddress']);

                    $customAttribute = $customer->getDataModel();
                    $customer->updateData($customAttribute);
                    $customer->save();
                }
                catch(\Exception $e)
                {
                    throw new \Magento\Framework\Exception\LocalizedException(__($e->getMessage()));
                }

            }
        }
    }
}

