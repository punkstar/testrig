<?php

namespace Meanbee\Testrig\CommandSet;

class Magento16 extends Magento1620 {
    public function getDescription() {
        return "The latest version of Magento 1.6 (" . $this->getVersion() . ")";
    }

    public function getCleanVersion() {
        return "1_6";
    }
}
