<?php declare(strict_types=1);

namespace Flavio\CatFact\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\CacheInterface;

class CatFact implements ArgumentInterface
{
    const DEFAULT_FACTS = array(
        'Cats are cute.',
        'A cat can spend five or more hours a day grooming himself.',
        'Mother cats teach their kittens to use the litter box.',
        'Owning a cat can reduce the risk of stroke and heart attack by a third.',
        'A cats field of vision is about 185 degrees.',
        'The average cat food meal is the equivalent to about five mice.',
        'Wikipedia has a recording of a cat meowing because why not?',
        'Cats sleep 70% of their lives.',
        'Cats can jump up to six times their length.',
        'The Maine Coone is the only native American long haired breed.'
    );

    public function __construct(
        private readonly CacheInterface $cache,
    ) {}

    public function getCatFact(): string
    {
        $catFactCacheData = $this->getFromCache();

        if (empty($catFactCacheData))
        {
            $catFactCacheData = $this->getRandomDefaultFact();
        }

        return $catFactCacheData;
    }

    private function getFromCache(): string
    {
        $data = $this->cache->load('flavio_cat_fact');
        if (!isset($data) || empty($data))
        {
            $data = "";
        }
        return $data;
    }

    private function getRandomDefaultFact(): string
    {
        $randomDefaultFact = self::DEFAULT_FACTS[array_rand(self::DEFAULT_FACTS)];
        return $randomDefaultFact;
    }

}
