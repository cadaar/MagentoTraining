<?php declare(strict_types=1);

namespace Flavio\ContactUs\Model\Resolver;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

use Flavio\ContactUs\Model\Resolver\DataProvider\Contactus;

class Contactusgraphql implements ResolverInterface
{
    //private $contactusDataProvider;

    public function __construct(
        private readonly Contactus $contactusDataProvider
    ) {
        //$this->contactusDataProvider = $contactusDataProvider;
    }

    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $fullname = $args['input']['fullname'];
        $email = $args['input']['email'];
        $telephone = $args['input']['telephone'];
        $message = $args['input']['message'];

        $success_message = $this->contactusDataProvider->contactUs(
            $fullname,
            $email,
            $telephone,
            $message
        );
        return $success_message;
    }
}
