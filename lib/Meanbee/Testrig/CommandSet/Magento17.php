<?php

namespace Meanbee\Testrig\CommandSet;

class Magento17 extends Magento1702 {
    public function getDescription() {
        return "The latest version of Magento 1.7 (" . $this->getVersion() . ")";
    }

    public function getCleanVersion() {
        return "1_7";
    }
}
