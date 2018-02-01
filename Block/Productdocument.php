<?php

/**
 * Mageprince
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @package Abm_Productdocument
 */

namespace Abm\Productdocument\Block;

/**
 * Class Document
 * @package Abm\Productdocument\Block
 */
class Productdocument extends \Magento\Framework\View\Element\Template
{
    /**
     * Productdocument collection
     *
     * @var Abm\Productdocument\Model\ResourceModel\Productdocument\Collection
     */
    private $productdocumentCollection = null;
    
    /**
     * Productdocument factory
     *
     * @var Abm\Productdocument\Model\ProductdocumentFactory
     */
    private $productdocumentCollectionFactory;
    
    /**
     * @var Abm\Productdocument\Helper\Data
     */
    private $dataHelper;

    /**
     * @var Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * @var Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var Magento\Framework\Registry
     */
    private $registry;
    
    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Abm\Productdocument\Model\ResourceModel\Productdocument\CollectionFactory $productdocumentCollectionFactory
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     * @param \Abm\Productdocument\Helper\Data $dataHelper
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Abm\Productdocument\Model\ResourceModel\Productdocument\CollectionFactory $productdocumentCollectionFactory,
        \Magento\Framework\ObjectManagerInterface $objectmanager,
        \Abm\Productdocument\Helper\Data $dataHelper,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->customerSession =$customerSession;
        $this->productdocumentCollectionFactory = $productdocumentCollectionFactory;
        $this->objectManager = $objectmanager;
        $this->dataHelper = $dataHelper;
        $this->scopeConfig = $context->getScopeConfig();
        $this->registry = $registry;
        parent::__construct(
            $context,
            $data
        );
    }
    
    /**
     * Check module is enable or not
     */
    public function isEnable()
    {
        return $this->getConfig('productdocument/general/enable');
    }

    /**
     * Retrieve productdocument collection
     *
     * @return Abm\Productdocument\Model\ResourceModel\Productdocument\Collection
     */
    public function getCollection()
    {
        $collection = $this->productdocumentCollectionFactory->create();
        return $collection;
    }
    
    /**
     * Filter productdocument collection by product Id
     *
     * @return collection
     */
    public function getDocument($productId)
    {
        $collection = $this->getCollection();
        $collection->getSelect()->where("store LIKE '%".$this->dataHelper->getStoreId()."%'");
        $collection->getSelect()->where("customer_group LIKE '%".$this->getCustomerId()."%'");
        $collection->getSelect()->where("products REGEXP '[[:<:]]".$productId."[[:>:]]'");
        return $collection;
    }

    /**
     * Filter productdocument collection by product Id
     * Tony add
     * 2017-09-05
     * @return collection
     */
    public function getDocumentNew($productId)
    {

        $categoryId = $this->getCategoryGroup($this->getCurrentCategoryIds());
        $categoryIds = "',".str_replace(',',',|',$categoryId).",'";

//        $collection = $this->getCollection();
//        $collection->getSelect()->where("store LIKE '%".$this->_dataHelper->getStoreId()."%'");
//        $collection->getSelect()->where("customer_group LIKE '%".$this->getCustomerId()."%'");
        $collection = $this->getCollection();
        $collection->getSelect()->where("store LIKE '%".$this->dataHelper->getStoreId()."%'");
        $collection->getSelect()->where("customer_group LIKE '%".$this->getCustomerId()."%'");
        $collection->getSelect()->where("products REGEXP '[[:<:]]".$productId."[[:>:]]' or concat(',',category_group,',') regexp concat($categoryIds)");


        return $collection;
    }

    /**
     * Return getCategory groups
     */
    public function getCategoryGroup($categorires)
    {
        $categories = implode(',', $categorires);
        return $categories;
    }

    /**
     * Retrive document url by document
     *
     * @return string
     */
    public function getDocumentUrl($document)
    {
        $url = $this->dataHelper->getBaseUrl().'/'.$document;
        return $url;
    }

    /**
     * Retrive current product id
     *
     * @return number
     */
    public function getCurrentId()
    {
        $product = $this->registry->registry('current_product');
        return $product->getId();
    }

    /**
     * tony add
     * @return mixed
     */
    public function getCurrentCategoryIds()
    {
        $product = $this->registry->registry('current_product');
        return $product->getCategoryIds();
    }

    /**
     * Retrive current customer id
     *
     * @return number
     */
    public function getCustomerId()
    {
        $customerId = $this->customerSession->getCustomer()->getGroupId();
        return $customerId;
    }

    /**
     * Retrive file icon image
     *
     * @return string
     */
    public function getFileIcon($fileExt)
    {
        if ($fileExt) {
            $iconImage = $this->getViewFileUrl('Abm_Productdocument::images/'.$fileExt.'.png');
        } else {
            $iconImage = $this->getViewFileUrl('Abm_Productdocument::images/unknown.png');
        }
        return $iconImage;
    }

    /**
     * Retrive link icon image
     *
     * @return string
     */
    public function getLinkIcon()
    {
        $iconImage = $this->getViewFileUrl('Abm_Productdocument::images/link.png');
        return $iconImage;
    }

    /**
     * Retrive file size by document
     *
     * @return number
     */
    public function getFileSize($document)
    {
        $url = $this->getDocumentUrl($document);
        $fileSize = $this->convertToReadableSize($this->remoteFileSize($url));
        return $fileSize;
    }

    /**
     * Retrive file size by url
     *
     * @return number
     */
    public function remoteFileSize($url)
    {
        $data = get_headers($url, true);
        if (isset($data['Content-Length']))
            return (int) $data['Content-Length'];
    }

    /**
     * Convert size into redable format
     */
    public function convertToReadableSize($size)
    {
        $base = log($size) / log(1024);
        $suffix = ["", " KB", " MB", " GB", " TB"];
        $f_base = floor($base);
        return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }

    /**
     * Retrive config value
     */
    public function getConfig($config)
    {
        return $this->scopeConfig->getValue(
            $config,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Retrive Tab Name
     */
    public function getTabName()
    {
        $tabName = __($this->getConfig('productdocument/general/tabname'));
        return $tabName;
    }
}
