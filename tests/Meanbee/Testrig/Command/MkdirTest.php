<?php

namespace Meanbee\Testrig\Command;

class MkdirTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function testCommandGeneration() {
        $cmd = new Mkdir('directory');

        $this->assertEquals("mkdir -p directory", $cmd->getCommand());
    }
}