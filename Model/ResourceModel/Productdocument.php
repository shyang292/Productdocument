<?php

/**
 * Mageprince
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @package Abm_Productattach
 */

namespace Abm\Productdocument\Model\ResourceModel;

/**
 * Class Productdocument
 * @package Abm\Productdocument\Model\ResourceModel
 */
class Productdocument extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('abm_productdocument', 'productdocument_id');
    }
}
