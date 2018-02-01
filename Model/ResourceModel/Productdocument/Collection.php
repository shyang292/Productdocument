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

namespace Abm\Productdocument\Model\ResourceModel\Productdocument;

/**
 * Class Collection
 * @package Abm\Productdocument\Model\ResourceModel\Productdocument
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'productdocument_id';

    /**
     * Resource initialization
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(
            'Abm\Productdocument\Model\Productdocument',
            'Abm\Productdocument\Model\ResourceModel\Productdocument'
        );
    }
}
