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

use Webmozart\Assert\Assert;

class EventDispatcher implements EventDispatcherInterface
{
    private $subscribers;

    public function registerSubscriber(string $eventName, callable $subscriber)
    {
        $this->subscribers[$eventName][] = $subscriber;
    }

    public function dispatch($event)
    {
        Assert::object($event, 'An event must be an object');

        $eventName = get_class($event);
        foreach ($this->subscribers[$eventName] ?? [] as $eventSubscriber) {
            $eventSubscriber($event);
        }
    }
}
