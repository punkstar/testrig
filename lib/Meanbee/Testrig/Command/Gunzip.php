<?php

namespace Meanbee\Testrig\Command;

class Gunzip extends Base {
    protected $_file = null;
    protected $_output = null;

    public function __construct($file, $output, $description = null) {
        parent::__construct();

        $this->_file = $file;
        $this->_output = $output;

        if (null == $description) {
            $this->_description = sprintf("Decompressing %s to %s", $file, $output);
        } else {
            $this->_description = $description;
        }
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getCommand() {
        return sprintf("tar xzf %s -C %s", $this->_file, $this->_output);
    }
}
