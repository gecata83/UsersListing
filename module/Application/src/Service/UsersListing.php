<?php
/**
 * Created by PhpStorm.
 * User: gecata
 * Date: 24.02.18
 * Time: 09:27
 */

namespace Application\Service;

use Zend\Cache\Storage\StorageInterface;
use Zend\Http\Client;

class UsersListing
{
    const MAIN_CACHE_KEY = "usersListing";

    /**
     * @var Client $client
     */
    protected $client;

    /**
     * @var $listingConfig
     */
    protected $listingConfig;

    /**
     * @var $cache StorageInterface
     */
    protected $cache;

    /**
     * UsersListing constructor.
     * @param Client $client
     * @param $listingConfig
     * @param StorageInterface $cache
     */
    public function __construct(Client $client, $listingConfig, StorageInterface $cache)
    {
        $this->client = $client;
        $this->listingConfig = $listingConfig;
        $this->cache = $cache;
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getResult($limit = 15, $offset = 0) :array
    {
        if ($this->cache->hasItem(self::MAIN_CACHE_KEY)) {
            $jsonData = $this->cache->getItem(self::MAIN_CACHE_KEY);
        } else {
            $jsonData = $this->makeRequest();
            $this->cache->setItem(self::MAIN_CACHE_KEY, $jsonData);
        }


        $result = json_decode($jsonData);

        $count = count($result);
        if ($count <= $offset) {
            $result = [];
        } elseif (count($result) <= $offset + $limit) {
            $result = array_slice($result, $offset);
        } else {
            $result = array_slice($result, $offset, $limit);
        }

        return $result;
    }

    /**
     * @return string
     * @throws \Exception
     */
    protected function makeRequest(): string
    {
        /**
         * @var $adapter Client\Adapter\Curl
         */
        $adapter = $this->client->getAdapter();
        $this->client->setUri($this->listingConfig['url']);
        $this->client->setMethod("GET");
        $adapter->setOptions([
            'curloptions' => [
                CURLOPT_HTTPHEADER => ['Accept: application/json'],
                CURLOPT_USERPWD    => $this->listingConfig["username"] . ":" . $this->listingConfig["password"]
            ]
        ]);

        $response = $this->client->send();

        /**
         * That is an ugly handling of this broken request. But for test purpose I think it would do the job.
         */
        if ($response->getStatusCode() >= 400) {
            throw new \Exception("Broken Request");
        }


        return $response->getBody();
    }
}