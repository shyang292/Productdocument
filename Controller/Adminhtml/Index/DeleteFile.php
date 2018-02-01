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
 * Class DeleteFile
 * @package Abm\Productdocument\Controller\Adminhtml\Index
 */
class DeleteFile extends \Magento\Backend\App\Action
{
    /**
     * @var \Abm\Productdocument\Model\Productdocument
     */
    private $documentModel;

    /**
     * @var \Magento\Framework\Filesystem\Driver\File
     */
    private $file;

    /**
     * @var \Magento\Framework\Filesystem
     */
    private $fileSystem;

    /**
     * @param \Magento\Backend\App\Action $context
     * @param \Abm\Productdocument\Model\Productdocument $documentModel
     * @param \Magento\Framework\Filesystem\Driver\File $file
     * @param \Magento\Framework\Filesystem $fileSystem
     */
    public function __construct(
        Action\Context $context,
        \Abm\Productdocument\Model\Productdocument $documentModel,
        \Magento\Framework\Filesystem\Driver\File $file,
        \Magento\Framework\Filesystem $fileSystem
    ) {
        $this->documentModel = $documentModel;
        $this->file = $file;
        $this->fileSystem = $fileSystem;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('Abm_Productdocument::productdocument_deletefile');
    }

    /**
     * Delete action
     *
     * @return void
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('productdocument_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->documentModel;
                $model->load($id);
                $currentFile = $model->getFile();
                $mediaDirectory = $this->fileSystem
                    ->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
                $fileRootDir = $mediaDirectory->getAbsolutePath().'productdocument';
                if ($this->file->isExists($fileRootDir . $currentFile)) {
                    $this->file->deleteFile($fileRootDir . $currentFile);
                    $model->setFile('');
                    $model->save();
                    $this->messageManager->addSuccess(__('The file has been deleted.'));
                }
                return $resultRedirect->setPath('*/*/edit', ['productdocument_id' => $id]);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['productdocument_id' => $id]);
            }
        }
    }
}
