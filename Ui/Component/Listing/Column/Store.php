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

namespace Abm\Productdocument\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Store
 * @package Abm\Productdocument\Ui\Component\Listing\Column
 */
class Store extends Column
{
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param ObjectManagerInterface $objectManager
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StoreManagerInterface $systemStore,
        array $components = [],
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('store');
            foreach ($dataSource['data']['items'] as &$items) {
                $stores = explode(',', $items['store']);
                $storeArray = [];
                foreach ($stores as $key => $store) {
                    $storeArray[$key] = $this->_systemStore->getStore($store)->getName();
                }
                $items['store'] = implode(' - ', $storeArray);
            }
        }
        
        return $dataSource;
    }
}
