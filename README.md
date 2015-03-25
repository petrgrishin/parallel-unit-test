# parallel-unit-test
Methodology of tests for parallel execution of code

## Installation
```json
{
    "require": {
        "petrgrishin/parallel-unit-test": "dev-master"
    },
    "scripts": {
      "test:parallel": "/usr/bin/env php vendor/petrgrishin/parallel-unit-test/src/cli.php test:parallel ./home-path-for-tests"
    }
}
```

## Create parallel test
```php
<?php
class SimpleParallelTest extends \PHPUnit_Framework_TestCase{

    /**
     * @group before
     */
    public function testInit() {
        //One run before parallel tests
    }

    /**
     * @group parallel
     */
    public function test() {
        //Will be launched in three parallel streams
        $this->assertTrue(true);
    }
}
```

## Run parallel test
```shel
composer test:parallel
```

