# Amp PHPUnit 10 Extension Example

This example shows the Extension system in PHPUnit 10 eating thrown exceptions, allowing for tests to pass when in reality 
the EventLoop crashed with an unhandled exception.

## Installation

This repo is not meant to be a package installed through Packagist. Please clone this repo using git if you'd like to run 
it.

## Usage

If you invoke this test case directly, without setting any environment variables, you will see that it passes.

```
$> ./vendor/bin/phpunit
PHPUnit 10.0.11 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.3
Configuration: /home/cspray/Code/personal/amp-phpunit10-example/phpunit.xml

.                                                                   1 / 1 (100%)

Time: 00:00.005, Memory: 8.00 MB

OK (1 test, 1 assertion)
```

If you invoke this test passing in the environment variable `EXIT_ON_EXCEPTION=1` you will see that the Extension 
experienced an exception that was eaten in the original test run.

```
$> EXIT_ON_EXCEPTION=1 ./vendor/bin/phpunit
PHPUnit 10.0.11 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.3
Configuration: /home/cspray/Code/personal/amp-phpunit10-example/phpunit.xml

Uncaught RuntimeException thrown in event loop callback Cspray\PhpUnit10Example\ExampleTest::Cspray\PhpUnit10Example\{closure} defined in /home/cspray/Code/personal/amp-phpunit10-example/tests/ExampleTest.php:12; use Revolt\EventLoop::setErrorHandler() to gracefully handle such exceptions: Threw exception in EventLoop
```

This spike is meant to demonstrate that the new PHPUnit 10 Extension system is not suitable for the next version of AsyncTestCase.