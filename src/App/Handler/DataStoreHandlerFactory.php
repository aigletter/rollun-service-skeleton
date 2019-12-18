<?php


namespace App\Handler;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use rollun\datastore\DataStore\Memory;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class DataStoreHandlerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $dataStore = $container->get('csv');
        return new DataStroreHandler($dataStore);
    }
}