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

namespace Abm\Productdocument\Controller\AbstractController;

use Magento\Framework\App\Action;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class View
 * @package Abm\Productdocument\Controller\AbstractController
 */
abstract class View extends Action\Action
{
    /**
     * @var \Abm\Productdocument\Controller\AbstractController\ProductdocumentLoaderInterface
     */
    private $productdocumentLoader;
    
    /**
     * @var PageFactory
     */
    private $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param OrderLoaderInterface $orderLoader
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Action\Context $context,
        ProductdocumentLoaderInterface $productdocumentLoader,
        PageFactory $resultPageFactory
    ) {
        $this->productdocumentLoader = $productdocumentLoader;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Productdocument view page
     *
     * @return void
     */
    public function execute()
    {
        if (!$this->productdocumentLoader->load($this->_request, $this->_response)) {
            return;
        }

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
