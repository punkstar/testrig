<?php

namespace Meanbee\Testrig\Command;

class MoveTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function testCommandGeneration() {
        $cmd = new Move('from', 'to');

        $this->assertEquals("mv from to", $cmd->getCommand());
    }
}