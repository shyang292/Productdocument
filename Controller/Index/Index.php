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

namespace Abm\Productdocument\Controller\Index;

use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 * @package Abm\Productdocument\Controller\Index
 */
class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    
    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    
    /**
     * Default Productdocument Index page
     *
     * @return void
     */
    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Site Productdocument'));
        $listBlock = $this->_view->getLayout()->getBlock('productdocument.list');

        if ($listBlock) {
            $currentPage = abs((int)($this->getRequest()->getParam('p')));
            if ($currentPage < 1) {
                $currentPage = 1;
            }
            
            $listBlock->setCurrentPage($currentPage);
        }
        
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        return $resultPage;
    }
}
