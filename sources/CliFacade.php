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
namespace Nia\Routing\Facade;

use Nia\RequestResponse\Cli\CliRequestInterface;
use Nia\Routing\Condition\CompositeCondition;
use Nia\Routing\Condition\ConditionInterface;
use Nia\Routing\Condition\MethodCondition;
use Nia\Routing\Filter\CompositeFilter;
use Nia\Routing\Filter\FilterInterface;
use Nia\Routing\Handler\HandlerInterface;
use Nia\Routing\Route\Route;
use Nia\Routing\Router\RouterInterface;

/**
 * Cli routing facade to simply add Cli routes to a given router.
 */
class CliFacade
{

    /**
     * The used router.
     *
     * @var RouterInterface
     */
    private $router = null;

    /**
     * Constructor.
     *
     * @param RouterInterface $router
     *            The used router.
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Creates a CLI route.
     *
     * @param HandlerInterface $handler
     *            The used handler to handle the match.
     * @param ConditionInterface $condition
     *            Optional condition.
     * @param FilterInterface $filter
     *            Optional filter.
     * @return CliFacade Reference to this instance.
     */
    public function cli(HandlerInterface $handler, ConditionInterface $condition = null, FilterInterface $filter = null): CliFacade
    {
        $conditions = [
            new MethodCondition(CliRequestInterface::METHOD_CLI)
        ];

        if ($condition) {
            $conditions[] = $condition;
        }

        $this->router->addRoute(new Route(new CompositeCondition($conditions), new CompositeFilter($filter ?? []), $handler));

        return $this;
    }
}

