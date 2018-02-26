<?php
/**
 * This file is part of bar.
 *
 * (c) Sascha Schimke <sascha@schimke.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sci\Bar\Tests;

use PHPUnit\Framework\TestCase;
use Sci\Bar\Bla;

class BlaTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_bla()
    {
        $subject = new Bla();

        self::assertInstanceOf(Bla::class, $subject);
    }
}
