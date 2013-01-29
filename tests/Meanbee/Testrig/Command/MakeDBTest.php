<?php

namespace Meanbee\Testrig\Command;

class MakeDBTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function testCommandGeneration() {
        $cmd = new MakeDB('database', 'root', 'root');

        $this->assertEquals("mysql -uroot -proot -e 'CREATE DATABASE database'", $cmd->getCommand());
    }
}