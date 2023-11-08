<?php

namespace Flavio\CatFact\Cron;

use Magento\Framework\HTTP\Client\Curl;
use Magento\Framework\App\CacheInterface;

class CatFacts
{
    const CAT_FACTS_URL = 'https://meowfacts.herokuapp.com/';

    public function __construct(
        private readonly Curl $curl,
        private readonly CacheInterface $cache,
    ) {}

    public function execute(): self
    {
        $catFactText = $this->getCatFact();
        $this->outputCatFact($catFactText);
        return $this;
    }

    private function getCatFact(): string
    {
        // get method
        $this->curl->get(self::CAT_FACTS_URL);

        // output of curl request
        $response = $this->curl->getBody();

        $decodedResponse = json_decode($response);
        $catFactData = $decodedResponse->{'data'};
        $catFact = array_reset($catFactData)[0];

        return $catFact;
    }

    private function outputCatFact(string $catFact): void
    {
        $this->saveToCache($catFact);
        //$this->logCatFact($catFact);
    }

    private function logCatFact($catFact): void
    {
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/cat-fact.log');
        $logger = new \Zend_Log();

        $logger->addWriter($writer);
        $logger->info(__METHOD__ . ' cron run begin >> ' . $catFact . ' << end');
    }

    private function saveToCache($catFact): void
    {
        $this->cache->save($catFact,"flavio_cat_fact", ["flavio_cat_fact_tag"], 82000);
    }
}
