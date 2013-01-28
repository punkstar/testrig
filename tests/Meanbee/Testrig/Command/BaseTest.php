<?php

namespace Meanbee\Testrig\Command;

class BaseTest extends \PHPUnit_Framework_TestCase {
    /** @var Base */
    protected $_obj = null;

    public function setUp() {
        $mock = $this->getMockForAbstractClass('\Meanbee\Testrig\Command\Base');

        $this->_obj = $mock;
    }

    public function tearDown() {
        $this->_obj = null;
    }

    /**
     * @test
     */
    public function testMockGeneration() {
        $this->assertInstanceOf('Meanbee\Testrig\Command\Base', $this->_obj);
    }

    /**
     * @test
     */
    public function testAssertNotZeroExitReported() {
        // Command should yield an error
        $command = "exit 1";
        $this->_obj->expects($this->any())
            ->method('getCommand')
            ->will($this->returnValue($command));

        $this->expectOutputRegex('/exited with a non-zero status/');

        $this->_obj->run();
    }

    /**
     * @test
     */
    public function testAssertNotZeroExitSuppressed() {
        // Command should yield an error
        $command = "exit 1";
        $this->_obj->expects($this->any())
            ->method('getCommand')
            ->will($this->returnValue($command));

        $this->_obj->setSuppressErrors(true);
        $this->_obj->run();

        $this->markTestIncomplete("Don't know how to check for the absence of a certain output regex");
    }
}