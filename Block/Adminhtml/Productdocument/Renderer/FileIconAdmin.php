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

namespace Abm\Productdocument\Block\Adminhtml\Productdocument\Renderer;
 
use Magento\Framework\DataObject;

/**
 * Class FileIconAdmin
 * @package Abm\Productdocument\Block\Adminhtml\Productdocument\Renderer
 */ 
class FileIconAdmin extends \Magento\Framework\Data\Form\Element\AbstractElement
{

    /**
     * @var \Magento\Framework\View\Asset\Repository
     */
    private $assetRepo;

    /**
     * @var \Abm\Productdocument\Helper\Data
     */
    private $dataHelper;

    /**
     * @var \Abm\Productdocument\Helper\Data
     */
    private $helper;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $urlBuider;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry = null;

    /**
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Abm\Productdocument\Helper\Data $dataHelper
     * @param \Magento\Backend\Helper\Data $helper
     * @param \Magento\Framework\UrlInterface $urlBuilder
     */
    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Abm\Productdocument\Helper\Data $dataHelper,
        \Magento\Backend\Helper\Data $helper,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Magento\Framework\Registry $registry
    ) {
        $this->dataHelper = $dataHelper;
        $this->assetRepo = $assetRepo;
        $this->helper = $helper;
        $this->urlBuilder = $urlBuilder;
        $this->coreRegistry = $registry;
    }
 
    /**
     * get customer group name
     * @param  DataObject $row
     * @return string
     */
    public function getElementHtml()
    {
        $fileIcon = '<h3>No File Uploded</h3>';
        $file = $this->getValue();
        if ($file) {
            $fileExt = pathinfo($file, PATHINFO_EXTENSION);
            if ($fileExt) {
                $iconImage = $this->assetRepo->getUrl(
                    'Abm_Productdocument::images/'.$fileExt.'.png'
                );
                $url = $this->dataHelper->getBaseUrl().'/'.$file;
                $fileIcon = "<a href=".$url." target='_blank'>
                    <img src='".$iconImage."' style='float: left;' />
                    <div>OPEN FILE</div></a>";
            } else {
                 $iconImage = $this->assetRepo->getUrl('Abm_Productdocument::images/unknown.png');
                 $fileIcon = "<img src='".$iconImage."' style='float: left;' />";
            }
            $documentId = $this->coreRegistry->registry('productdocument_id');
            $fileIcon .= "<a href='".$this->urlBuilder->getUrl(
                'productdocument/index/deletefile', $param = ['productdocument_id' => $documentId])."'>
                <div style='color:red;'>DELETE FILE</div></a>";
        }
        return $fileIcon;
    }
}
