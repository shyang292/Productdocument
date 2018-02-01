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
use Abm\Productdocument\Helper\Data;

/**
 * Class Save
 * @package Abm\Productdocument\Controller\Adminhtml\Index
 */
class Save extends \Magento\Backend\App\Action
{
    /**
     * @var PostDataProcessor
     */
    private $dataProcessor;

    /**
     * @var \Abm\Productdocument\Helper\Data
     */
    private $helper;

    /**
     * @var \Abm\Productdocument\Model\Productdocument
     */
    private $documentModel;

    /**
     * @var \Magento\Backend\Model\Session
     */
    private $backSession;

    /**
     * @param \Magento\Backend\App\Action $context
     * @param PostDataProcessor $dataProcessor
     * @param \Abm\Productdocument\Model\Productdocument $documentModel
     * @param \Magento\Backend\Model\Session $backSession
     * @param \Abm\Productdocument\Helper\Data $data
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        \Abm\Productdocument\Model\Productdocument $documentModel,
        Data $helper
    ) {
        $this->dataProcessor = $dataProcessor;
        $this->documentModel = $documentModel;
        $this->backSession = $context->getSession();
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abm_Productdocument::save');
    }

    /**
     * Save action
     *
     * @return void
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $data = $this->dataProcessor->filter($data);
            $customerGroup = $this->helper->getCustomerGroup($data['customer_group']);
            $categoryGroup = $this->helper->getCustomerGroup($data['category_group']); /*tony add*/
            $store = $this->helper->getStores($data['store']);
            $data['customer_group'] = $customerGroup;
            $data['category_group'] = $categoryGroup; /*tony add*/
            $data['store'] = $store;
            $uploadedFile = '';
            $model = $this->documentModel;
            $id = $this->getRequest()->getParam('productdocument_id');
            
            if ($id) {
                $model->load($id);
                $uploadedFile = $model->getFile();
            }
            
            $model->addData($data);

            if (!$this->dataProcessor->validate($data)) {
                $this->_redirect('*/*/edit', ['productdocument_id' => $model->getId(), '_current' => true]);
                return;
            }

            try {
                $imageFile = $this->helper->uploadFile('file', $model);
                $model->save();
                $this->messageManager->addSuccess(__('Document has been saved.'));
                $this->backSession->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', ['productdocument_id' => $model->getId(), '_current' => true]);
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (\Magento\Framework\Model\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the documentment.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', ['productdocument_id' => $this->getRequest()->getParam('productdocument_id')]);
            return;
        }
        $this->_redirect('*/*/');
    }
}
