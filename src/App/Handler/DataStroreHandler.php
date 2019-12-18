<?php


namespace App\Handler;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use rollun\datastore\DataStore\Interfaces\DataStoreInterface;
use Xiag\Rql\Parser\Query;
use Zend\Diactoros\Response\JsonResponse;

class DataStroreHandler implements RequestHandlerInterface
{
    protected $dataStore;

    public function __construct(DataStoreInterface $dataStore)
    {
        $this->dataStore = $dataStore;
    }

    /**
     * @inheritDoc
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->dataStore->create([
            'id' => 3,
            'value' => 'Test 3',
        ]);
        $this->dataStore->create([
            'id' => 1,
            'value' => 'Test 1',
        ]);

        //return new JsonResponse($this->dataStore->query(new Query()));


    }
}