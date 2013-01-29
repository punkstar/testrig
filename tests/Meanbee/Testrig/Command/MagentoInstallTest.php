<?php

namespace Meanbee\Testrig\Command;

class MagentoInstallTest extends \PHPUnit_Framework_TestCase {
    /**
     * @test
     */
    public function testCommandStripsTrailingSlashFromBaseUrl() {
        $cmd = new MagentoInstall('directory', 'dbname', 'dbuser', 'dbpass', 'http://www.nicksays.co.uk/');

        $command_string = $cmd->getCommand();

        $this->assertContains('--url http://www.nicksays.co.uk ', $command_string);
    }
}