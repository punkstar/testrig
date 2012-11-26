<?php

namespace Meanbee\Testrig\CommandSet;

class Magento14 extends Magento1420 {
    public function getDescription() {
        return "The latest version of Magento 1.4 (" . $this->getVersion() . ")";
    }

    public function getCleanVersion() {
        return "1_4";
    }
}
