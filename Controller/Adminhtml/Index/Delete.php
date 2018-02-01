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
 * Class Delete
 * @package Abm\Productdocument\Controller\Adminhtml\Index
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var \Abm\Productdocument\Model\Productdocument
     */
    private $documentModel;

    /**
     * @param \Magento\Backend\App\Action $context
     * @param \Abm\Productdocument\Model\Productdocument $documentModel
     */
    public function __construct(
        Action\Context $context,
        \Abm\Productdocument\Model\Productdocument $documentModel
    ) {
        $this->documentModel = $documentModel;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abm_Productdocument::productdocument_delete');
    }

    /**
     * Delete action
     *
     * @return void
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('productdocument_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->documentModel;
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The data has been deleted.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['page_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a data to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
