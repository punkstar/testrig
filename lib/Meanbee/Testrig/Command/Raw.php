<?php

namespace Meanbee\Testrig\Command;

class Raw extends Base {
    protected $_command = null;

    public function __construct($command, $description = null) {
        parent::__construct();

        $this->_command= $command;

        if (null == $description) {
            $this->_description = sprintf("Running command");
        } else {
            $this->_description = $description;
        }
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getCommand() {
        return $this->_command;
    }
}
