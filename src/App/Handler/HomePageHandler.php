<?php
/**
 * @copyright Copyright © 2014 Rollun LC (http://rollun.com/)
 * @license LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use rollun\datastore\DataStore\Memory;
use rollun\datastore\Rql\RqlParser;
use Xiag\Rql\Parser\Node\Query\ArrayOperator\InNode;
use Xiag\Rql\Parser\Node\Query\LogicOperator\AndNode;
use Xiag\Rql\Parser\Node\Query\LogicOperator\OrNode;
use Xiag\Rql\Parser\Node\Query\ScalarOperator\EqNode;
use Xiag\Rql\Parser\Node\SelectNode;
use Xiag\Rql\Parser\Node\SortNode;
use Xiag\Rql\Parser\Query;
use Zend\Diactoros\Response\HtmlResponse;

class HomePageHandler implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $dataStore = new Memory();

        $dataStore->create([
            'id' => 3,
            'value' => 'Test 3',
        ]);

        $dataStore->create([
            'id' => 1,
            'value' => 'Test 1',
        ]);

        $dataStore->create([
            'id' => 2,
            'value' => 'Test 2',
        ]);


        /*
         * Scalar Nodes
         */
        $query = new Query();
        $eqNode = new EqNode('id', 2);
        $query->setQuery($eqNode);
        $result = $dataStore->query($query);

        /*
         * Logic Nodes
         */
        $query = new Query();
        $eqNode1 = new EqNode('id', 3);
        $eqNode2 = new EqNode('id', 2);
        $orNode = new OrNode([$eqNode1, $eqNode2]);
        $query->setQuery($orNode);
        $result = $dataStore->query($query);

        /*
         * Array Nodes
         */
        $query = new Query();
        $arrNode = new InNode('id', [1, 3]);
        $query->setQuery($arrNode);
        $result = $dataStore->query($query);

        /*
         * Sort Node
         */
        $query = new Query();
        $query->setQuery(new InNode('id', [3, 2]));
        $sortNode = new SortNode(['id' => SortNode::SORT_ASC]);
        $query->setSort($sortNode);
        $result = $dataStore->query($query);

        /*
         * Select Node
         */
        $query = new Query();
        $query->setQuery(new InNode('id', [3, 2]));
        $selectNode = new SelectNode(['value']);
        $query->setSelect($selectNode);
        $result = $dataStore->query($query);
        //$limitNode = new \Xiag\Rql\Parser\Node\Node\LimitNode(2, 1);
        //$query->setLimit($limitNode);


        $query = RqlParser::rqlDecode('or(eq(id,1),eq(id,3))&sort(-id)&select(value)&limit(1,1)');
        $result = $dataStore->query($query);

        $string = RqlParser::rqlEncode($query);





        //$a = $request->getQueryParams();

        //throw new \Exception('ex', 400);
        return new HtmlResponse(json_encode($result));
    }
}
