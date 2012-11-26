<?php

namespace Meanbee\Testrig\CommandSet;

class Magento15 extends Magento1510 {
    public function getDescription() {
        return "The latest version of Magento 1.5 (" . $this->getVersion() . ")";
    }

    public function getCleanVersion() {
        return "1_5";
    }
}
