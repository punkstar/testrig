<?php

namespace Meanbee\Testrig\Command;

class MakeDB extends Base {
    protected $_dbname = '';
    protected $_user = '';
    protected $_pass = '';

    public function __construct($database, $user = 'root', $password = 'toor', $description = null) {
        parent::__construct();

        $this->_dbname = $database;
        $this->_user = $user;
        $this->_pass = $password;

        if (null == $description) {
            $this->_description = sprintf("Creating a database: %s", $database);
        } else {
            $this->_description = $description;
        }
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getCommand() {
        return sprintf("mysql -u%s -p%s -e 'CREATE DATABASE %s'", $this->_user, $this->_pass, $this->_dbname);
    }
}
