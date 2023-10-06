<?php declare(strict_types=1);

namespace Macademy\Bootcamp\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Webapi\Rest\Request;

class Post implements HttpPostActionInterface
{
    public function __construct(
        private readonly JsonFactory $jsonFactory,
        private readonly Request $request,
    ) {}

    public function execute(): Json
    {
        $json = $this->jsonFactory->create();

        //$data = file_get_contents("php://input");
        //$valueFromRequest = json_decode($data,true);
        $post = $this->request->getBodyParams()[0];

//        $post = $this->request->getBodyParams()[0];
//        echo '<pre>';
//        var_dump($post);
//        echo '</pre>';
//        die();

        return $json->setData([
                'success' => !empty($post),
                '$valueFromRequest' => $post
            ]
        );
    }
}
