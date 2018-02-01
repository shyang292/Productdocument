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

namespace Abm\Productdocument\Controller\AbstractController;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Registry;

/**
 * Class ProductdocumentLoader
 * @package Abm\Productdocument\Controller\AbstractController
 */
class ProductdocumentLoader implements ProductdocumentLoaderInterface
{
    /**
     * @var \Abm\Productdocument\Model\ProductdocumentFactory
     */
    private $productdocumentFactory;

    /**
     * @var \Magento\Framework\Registry
     */
    private $registry;

    /**
     * @var \Magento\Framework\UrlInterface
     */
    private $url;

    /**
     * @param \Abm\Productdocument\Model\ProductdocumentFactory $productdocumentFactory
     * @param OrderViewAuthorizationInterface $orderAuthorization
     * @param Registry $registry
     * @param \Magento\Framework\UrlInterface $url
     */
    public function __construct(
        \Abm\Productdocument\Model\ProductdocumentFactory $productdocumentFactory,
        Registry $registry,
        \Magento\Framework\UrlInterface $url
    ) {
        $this->productdocumentFactory = $productdocumentFactory;
        $this->registry = $registry;
        $this->url = $url;
    }

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @return bool
     */
    public function load(RequestInterface $request, ResponseInterface $response)
    {
        $id = (int)$request->getParam('id');
        if (!$id) {
            $request->initForward();
            $request->setActionName('noroute');
            $request->setDispatched(false);
            return false;
        }

        $productdocument = $this->productdocumentFactory->create()->load($id);
        $this->registry->register('current_productdocument', $productdocument);
        return true;
    }
}
