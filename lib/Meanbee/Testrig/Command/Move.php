<?php

namespace Meanbee\Testrig\Command;

class Move extends Base {
    protected $_from = null;
    protected $_to = null;

    public function __construct($from, $to, $description = null) {
        parent::__construct();

        $this->_from = $from;
        $this->_to = $to;

        if (null == $description) {
            $this->_description = sprintf("Moving %s to %s", $from, $to);
        } else {
            $this->_description = $description;
        }
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getCommand() {
        return sprintf("mv %s %s", $this->_from, $this->_to);
    }
}
