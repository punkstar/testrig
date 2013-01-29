<?php

namespace Meanbee\Testrig\Command;

class GunzipTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function testCommandGeneration() {
        $cmd = new Gunzip('file.tar.gz', 'directory');

        $this->assertEquals("tar xzf file.tar.gz -C directory", $cmd->getCommand());
    }
}