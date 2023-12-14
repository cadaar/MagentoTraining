<?php declare(strict_types=1);

namespace Flavio\GraphQl\Model\Resolver;


use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class IsOversizedResolver implements ResolverInterface
{

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ):bool
    {
        $product = $value['model'];

        return $product->getWeight() >= 50;
    }
}
