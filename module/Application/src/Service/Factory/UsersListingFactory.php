<?php
/**
 * Created by PhpStorm.
 * User: gecata
 * Date: 24.02.18
 * Time: 09:27
 */

namespace Application\Service\Factory;

use Application\Service\UsersListing;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\Cache\Storage\Adapter\Apc;
use Zend\Cache\StorageFactory;
use Zend\Http\Client;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class UsersListingFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : UsersListing
    {
        $httpClient         = $container->get(Client::class);
        $httpCurlAdapter    = $container->get(Client\Adapter\Curl::class);
        $mainConfig         = $container->get('Config');
        $userListingConfigs = $mainConfig['listing-config'];
        $cache = StorageFactory::factory($mainConfig['cache-options']);

        $httpClient->setAdapter($httpCurlAdapter);

        return new UsersListing($httpClient, $userListingConfigs, $cache);
    }
}