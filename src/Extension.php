<?php

namespace Cspray\PhpUnit10Example;

use PHPUnit\Event\Test\Finished;
use PHPUnit\Event\Test\FinishedSubscriber;
use PHPUnit\Event\Test\Prepared;
use PHPUnit\Event\Test\PreparedSubscriber;
use PHPUnit\Runner\Extension\Extension as PHPUnitExtension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;
use Revolt\EventLoop;
use stdClass;

class Extension implements PHPUnitExtension {

    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters) : void {
        $context = new stdClass();
        $context->suspension = null;
        $facade->registerSubscriber(new class($context) implements PreparedSubscriber {
            public function __construct(
                private readonly stdClass $context
            ) {}

            public function notify(Prepared $event) : void {
                $this->context->suspension = EventLoop::getSuspension();
            }
        });

        $facade->registerSubscriber(new class($context) implements FinishedSubscriber {
            public function __construct(
                private readonly stdClass $context
            ) {}

            public function notify(Finished $event) : void {
                try {
                    $this->context->suspension->suspend();
                } catch (\Throwable $e) {
                    if (getenv('EXIT_ON_EXCEPTION') === '1') {
                        exit($e->getMessage());
                    }

                    throw $e;
                }
            }
        });
    }
}