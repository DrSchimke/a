<?php
/**
 * This file is part of foobar.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Bar;

use Psr\Container\ContainerInterface;
use Webmozart\Assert\Assert;

class EventDispatcherDecorator implements EventDispatcherInterface
{
    /** @var EventDispatcher */
    private $dispatcher;

    /* @var ContainerInterface */
    private $container;

    /** @var array[] */
    private $handlers;

    public function __construct(EventDispatcher $dispatcher, ContainerInterface $container)
    {
        $this->dispatcher = $dispatcher;
        $this->container = $container;
        $this->handlers = [];
    }

    public function registerLazySubscriber($eventType, $serviceId, $methodName)
    {
        Assert::classExists($eventType);
        Assert::true($this->container->has($serviceId), sprintf('Unknown service %s', $serviceId));

        $this->handlers[$eventType][$serviceId] = $methodName;
    }

    public function dispatch($event)
    {
        $this->lazy($event);

        $this->dispatcher->dispatch($event);
    }

    private function lazy($event)
    {
        Assert::object($event, 'An event must be an object');

        $eventName = get_class($event);

        foreach ($this->handlers[$eventName] ?? [] as $serviceId => $methodName) {
            $this->dispatcher->registerSubscriber($eventName, [$this->container->get($serviceId), $methodName]);
        }

        unset($this->handlers[$eventName]);
    }
}
