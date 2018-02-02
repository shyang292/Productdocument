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

namespace Abm\Productdocument\Block\Adminhtml\Productdocument;

/**
 * Class Grid
 * @package Abm\Productdocument\Block\Adminhtml\Productdocument
 */
class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    /**
     * @var \Abm\Productdocument\Model\ResourceModel\Productdocument\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Abm\Productdocument\Model\Productdocument
     */
    private $productdocument;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Abm\Productdocument\Model\Productdocument $productdocumentPage
     * @param \Abm\Productdocument\Model\ResourceModel\Productdocument\CollectionFactory $collectionFactory
     * @param \Magento\Core\Model\PageLayout\Config\Builder $pageLayoutBuilder
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Abm\Productdocument\Model\Productdocument $productdocument,
        \Abm\Productdocument\Model\ResourceModel\Productdocument\CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->productdocument = $productdocument;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setId('productdocumentGrid');
        $this->setDefaultSort('productdocument_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid
     */
    public function _prepareCollection()
    {
        $collection = $this->collectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare columns
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    public function _prepareColumns()
    {
        $this->addColumn('productdocument_id', [
            'header'    => __('ID'),
            'index'     => 'productdocument_id',
        ]);
        
        $this->addColumn(
            'docname',
            [
                'header' => __('Name'),
                'index' => 'docname'
            ]
        );
        $this->addColumn(
            'url',
            [
                'header' => __('FileName'),
                'index' => 'url'
            ]
        );

//        $this->addColumn(
//            'description',
//            [
//                'header' => __('Description'),
//                'index' => 'description'
//            ]
//        );

//        $this->addColumn(
//            'file',
//            [
//                'header' => __('File'),
//                'index' => 'file',
//                'renderer' => 'Abm\Productdocument\Block\Adminhtml\Productdocument\Renderer\FileIcon'
//            ]
//        );
        
        $this->addColumn(
            'customer_group',
            [
                'header' => __('Customer Group'),
                'index' => 'customer_group',
                'renderer' => 'Abm\Productdocument\Block\Adminhtml\Productdocument\Renderer\Group'
            ]
        );

        $this->addColumn(
            'store',
            [
                'header' => __('Store '),
                'index' => 'store',
                'renderer' => 'Abm\Productdocument\Block\Adminhtml\Productdocument\Renderer\Store'
            ]
        );

        $this->addColumn(
            'active',
            [
                'header' => __('Active'),
                'index' => 'active',
                'renderer' => 'Abm\Productdocument\Block\Adminhtml\Productdocument\Renderer\Active'
            ]
        );
       
        $this->addColumn(
            'action',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'class' => 'action-secondary',
                        'url' => [
                            'base' => '*/*/edit',
                            'params' => ['store' => $this->getRequest()->getParam('store')]
                        ],
                        'field' => 'productdocument_id'
                    ]
                ],
                'sortable' => false,
                'filter' => false,
                'css_class' => 'scalable action-secondary',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    /**
     * Row click url
     *
     * @param \Magento\Framework\Object $row
     * @return string
     */
    public function getRowUrl($row)
    {
        return false;
    }

    /**
     * Get grid url
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', ['_current' => true]);
    }
}
