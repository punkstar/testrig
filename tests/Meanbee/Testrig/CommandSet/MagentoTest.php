<?php

namespace Meanbee\Testrig\CommandSet;

class MagentoTest extends \PHPUnit_Framework_TestCase {
    /** @var Magento */
    protected $_obj = null;

    public function setUp() {
        $mock = $this->getMockForAbstractClass('\Meanbee\Testrig\CommandSet\Magento', array(), '', false);

        $this->_obj = $mock;
    }

    public function tearDown() {
        $this->_obj = null;
    }

    /**
     * @test
     */
    public function testMockGeneration() {
        $this->assertInstanceOf('Meanbee\Testrig\CommandSet\Magento', $this->_obj);
    }

    /**
     * @test
     */
    public function testTrailingSlashesOnBaseUrl() {
        $this->_obj->expects($this->any())
            ->method('getVersion')
            ->will($this->returnValue('1.7'));

        $this->_obj->setOpt('base_url', 'http://www.nicksays.co.uk/');
        $this->assertEquals('http://www.nicksays.co.uk/1_7', $this->_obj->getBaseUrl());

        $this->_obj->setOpt('base_url', 'http://www.nicksays.co.uk');
        $this->assertEquals('http://www.nicksays.co.uk/1_7', $this->_obj->getBaseUrl());
    }
}