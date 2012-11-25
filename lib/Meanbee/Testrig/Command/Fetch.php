<?php

namespace Meanbee\Testrig\Command;

class Fetch extends Base {
    protected $_url = null;
    protected $_output = null;
    protected $_description = null;

    public function __construct($url, $output, $description = null) {
        parent::__construct();

        $this->_url = $url;
        $this->_output = $output;

        if (null == $description) {
            $this->_description = sprintf("Downloading %s", $url);
        } else {
            $this->_description = $description;
        }
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getCommand() {
        return sprintf("wget %s -O %s", $this->_url, $this->_output);
    }
}
