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

namespace Abm\Productdocument\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;

/**
 * Class Edit
 * @package Abm\Productdocument\Controller\Adminhtml\Index
 */
class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry = null;
    
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;

    /**
     * @var \Abm\Productdocument\Model\Productdocument
     */
    private $documentModel;

    /**
     * @var  \Magento\Backend\Model\Session
     */
    private $backSession;

    /**
     * @param \Magento\Backend\App\Action $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param \Abm\Productdocument\Model\Productdocument $documentModel
     * @param \Magento\Backend\Model\Session $backSession
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        \Abm\Productdocument\Model\Productdocument $documentModel
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->coreRegistry = $registry;
        $this->documentModel = $documentModel;
        $this->backSession = $context->getSession();
        parent::__construct($context);
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abm_Productdocument::save');
    }

    /**
     * Init actions
     *
     * @return $this
     */
    public function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu(
            'Abm_Productdocument::productdocument_manage'
        )->addBreadcrumb(
            __('Document'),
            __('Document')
        )->addBreadcrumb(
            __('Manage Document'),
            __('Manage Document')
        );
        return $resultPage;
    }

    /**
     * Edit CMS page
     *
     * @return void
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('productdocument_id');
        $model = $this->documentModel;

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Document no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
            $this->coreRegistry->register('productdocument_id', $model->getId());
        }

        // 3. Set entered data if was error when we do save
        $data = $this->backSession->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        $this->coreRegistry->register('productdocument', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Document') : __('New Document'),
            $id ? __('Edit Document') : __('New Document')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Productdocument'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Document'));
        return $resultPage;
    }
}
