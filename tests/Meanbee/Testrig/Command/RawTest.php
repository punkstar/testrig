<?php

namespace Meanbee\Testrig\Command;

class RawTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function testCommandGeneration() {
        $cmd_str = 'execute raw command';
        $cmd = new Raw($cmd_str);

        $this->assertEquals($cmd_str, $cmd->getCommand());
    }
}