<?php
/**
 * @file      testHelloWorld.php
 * @brief     This file is the test file used to create my first test if phpunit is working localy
 * @author    Created by Antoine Roulin
 * @version   27.02.2023
 */

class testHelloWorld extends \PHPUnit\Framework\TestCase
{
    public function testTrueEqualsTrue(){
        $this->assertEquals(True, True);
    }
}