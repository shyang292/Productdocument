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
 * Class FileIcon
 * @package Abm\Productdocument\Block\Adminhtml\Productdocument\Renderer
 */
class FileIcon extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
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
     * @param \Magento\Framework\View\Asset\Repository $assetRepo
     * @param \Abm\Productdocument\Helper\Data $dataHelper
     */
    public function __construct(
        \Magento\Framework\View\Asset\Repository $assetRepo,
        \Abm\Productdocument\Helper\Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
        $this->assetRepo = $assetRepo;
    }
 
    /**
     * get customer group name
     * @param  DataObject $row
     * @return string
     */
    public function render(DataObject $row)
    {
        $file = $row->getFile();
        $fileExt = pathinfo($file, PATHINFO_EXTENSION);
        if ($fileExt) {
            $iconImage = $this->assetRepo->getUrl('Abm_Productdocument::images/'.$fileExt.'.png');
            $fileIcon = "<a href=".$this->dataHelper->getBaseUrl().'/'.$file." target='_blank'>
            <img src='".$iconImage."' /></a>";
        } else {
            $iconImage = $this->assetRepo->getUrl('Abm_Productdocument::images/unknown.png');
            $fileIcon = "<img src='".$iconImage."' />";
        }
        
        return $fileIcon;
    }
}
