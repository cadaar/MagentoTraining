<?php declare(strict_types=1);

namespace Flavio\CatFact\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\CacheInterface;

class CatFact implements ArgumentInterface
{
    public function __construct(
        private readonly CacheInterface $cache,
    ) {}

    public function getCatFact(): string
    {
        $catFactCacheData = $this->cache->load('flavio_cat_fact');
        return $catFactCacheData;
    }

}
