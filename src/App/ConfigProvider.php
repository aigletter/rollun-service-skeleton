<?php
/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */

declare(strict_types = 1);

namespace App;

use App\Handler\DataStoreHandlerFactory;
use App\Handler\DataStroreHandler;
use App\Services\Market\MarketFactory;
use App\Services\Market\Order;
use App\Services\Market\ItemFactory;
use rollun\callback\Middleware\CallablePluginManagerFactory;
use rollun\datastore\DataStore\Aspect\Factory\AspectAbstractFactory;
use rollun\datastore\DataStore\ConditionBuilder\SqlConditionBuilderAbstractFactory;
use rollun\datastore\DataStore\CsvBase;
use rollun\datastore\DataStore\Factory\CacheableAbstractFactory;
use rollun\datastore\DataStore\Factory\CsvAbstractFactory;
use rollun\datastore\DataStore\Factory\DbTableAbstractFactory;
use rollun\datastore\DataStore\Factory\HttpClientAbstractFactory;
use rollun\datastore\DataStore\Factory\MemoryAbstractFactory;
use rollun\datastore\TableGateway\Factory\SqlQueryBuilderAbstractFactory;
use rollun\datastore\TableGateway\Factory\TableGatewayAbstractFactory;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'dataStore' => [
                'memory' => [
                    'class' => 'rollun\datastore\DataStore\Memory',
                ],
                'csv' => [
                    'class' => CsvBase::class,
                    'filename' => 'data/test.csv',
                    'delimiter' => ','
                ]
            ],
            CallablePluginManagerFactory::KEY_INTERRUPTERS => [
                'invokables' => [
                    'order' => Order::class,
                ],
                'factories' => [
                    //'item' => ItemFactory::class,
                    'market' => MarketFactory::class,
                ]
            ],
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\HomePageHandler::class => Handler\HomePageHandler::class,
                'order' => Order::class,
            ],
            'factories' => [
                DataStroreHandler::class => DataStoreHandlerFactory::class
            ],
            'abstract_factories' => [
                MemoryAbstractFactory::class,
            ],
        ];
    }
}
