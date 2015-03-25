<?php
/**
 * @author Petr Grishin <petr.grishin@grishini.ru>
 */
 

class SimpleTest extends \PHPUnit_Framework_TestCase{

    /**
     * @group before
     */
    public function testInit() {
        printf("\n====================\nOne run before parallel tests\n====================\n");
    }

    /**
     * @group parallel
     */
    public function test() {
        return $this->assertTrue(true);
    }
}