<?php

namespace Cspray\PhpUnit10Example;

use PHPUnit\Framework\TestCase;
use Revolt\EventLoop;
use RuntimeException;

class ExampleTest extends TestCase {

    public function testSomething() : void {
        EventLoop::defer(static fn() => throw new RuntimeException('Threw exception in EventLoop'));
        self::assertTrue(true);
    }

}