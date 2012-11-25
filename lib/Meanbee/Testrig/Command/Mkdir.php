<?php

namespace Meanbee\Testrig\Command;

class Mkdir extends Base {
    protected $_directory = null;
    protected $_description = null;

    public function __construct($directory, $description = null) {
        parent::__construct();

        $this->_directory = $directory;

        if (null == $description) {
            $this->_description = sprintf("Making directory: %s", $directory);
        } else {
            $this->_description = $description;
        }
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getCommand() {
        return sprintf("mkdir -p %s", $this->_directory);
    }
}
