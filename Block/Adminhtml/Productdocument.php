<?php

/**
 * Mageprince
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @package Prince_Productdocument
 */

namespace Abm\Productdocument\Block\Adminhtml;

/**
 * Class Productdocument
 * @package Abm\Productdocument\Block\Adminhtml
 */
class Productdocument extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    public function _construct()
    {
        $this->_controller = 'adminhtml_productdocument';
        $this->_blockGroup = 'Abm_productdocument';
        $this->_headerText = __('Product Documents');
        $this->_addButtonLabel = __('Add New Document');
        parent::_construct();
        if ($this->_isAllowedAction('Abm_Productdocument::save')) {
            $this->buttonList->update('add', 'label', __('Add New Document'));
        } else {
            $this->buttonList->remove('add');
        }
    }
    
    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    public function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
