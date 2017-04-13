<?php
/*
 * This file is part of the nia framework architecture.
 *
 * (c) Patrick Ullmann <patrick.ullmann@nat-software.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare(strict_types = 1);
namespace Test\Nia\Routing\Facade;

use PHPUnit\Framework\TestCase;
use Nia\Routing\Facade;
use Nia\Routing\Router\Router;
use Nia\Routing\Facade\CliFacade;
use Nia\Routing\Handler\HandlerInterface;
use Nia\Routing\Filter\CompositeFilterInterface;
use Nia\Routing\Condition\CompositeConditionInterface;
use Nia\Routing\Condition\MethodCondition;

/**
 * Unit test for \Nia\Routing\Facade\CliFacade.
 */
class CliFacadeTest extends TestCase
{

    private $router = null;

    public function setUp()
    {
        $this->router = new Router();
    }

    public function tearDown()
    {
        $this->router = null;
    }

    /**
     * @covers \Nia\Routing\Facade\CliFacade
     */
    public function testCli()
    {
        $handler = $this->createMock(HandlerInterface::class);

        $facade = new CliFacade($this->router);
        $facade->cli($handler);

        $routes = $this->router->getRoutes();
        $this->assertSame(1, count($routes));

        $route = $routes[0];
        $this->assertSame($handler, $route->getHandler());

        $condition = $route->getCondition();
        /** @var $condition CompositeConditionInterface */
        $this->assertInstanceOf(CompositeConditionInterface::class, $condition);
        $this->assertSame(1, count($condition->getConditions()));
        $this->assertInstanceOf(MethodCondition::class, $condition->getConditions()[0]);

        $filter = $route->getFilter();
        /** @var $filter CompositeFilterInterface */
        $this->assertInstanceOf(CompositeFilterInterface::class, $filter);
        $this->assertSame(0, count($filter->getFilters()));
    }
}
