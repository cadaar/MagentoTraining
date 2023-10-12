<?php declare(strict_types=1);

namespace Flavio\CustomCheckout\Controller\Store;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;

//use Magento\Framework\App\RequestInterface;
//use Magento\Framework\Event\ManagerInterface as EventManager;
//use Magento\Framework\View\Result\Page;
//use Magento\Framework\View\Result\PageFactory;

class Index implements HttpGetActionInterface
{
    public function __construct(
//        private PageFactory $pageFactory,
//        private EventManager $eventManager,
//        private RequestInterface $request,
        private readonly ScopeConfigInterface $scopeConfig,
        private readonly JsonFactory $jsonFactory,
    ) {}

    public function execute(): Json
    {
        $storePhone = $this->scopeConfig->getValue('general/store_information/phone');
        //return $storePhone;
        $json = $this->jsonFactory->create();
        return $json->setData([
                'success' => !empty($storePhone),
                'value' => $storePhone
            ]
        );
    }

}
