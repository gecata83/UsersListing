<?php
/**
 * Created by PhpStorm.
 * User: gecata
 * Date: 24.02.18
 * Time: 09:21
 */

namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use Application\Service\UsersListing;
use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class IndexControllerFactory implements FactoryInterface
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
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : IndexController
    {
        // TODO: Implement __invoke() method.

        $linkedListService = $container->get(UsersListing::class);

        return new IndexController($linkedListService);
    }
}