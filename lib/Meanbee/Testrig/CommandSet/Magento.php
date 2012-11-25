<?php

namespace Meanbee\Testrig\CommandSet;

abstract class Magento {
    abstract public function getVersion();
    abstract public function getCommands();
    abstract public function getUrl();

    public function __construct($options = array()) {
        $required_keys = array('base_url', 'project_name', 'project_dir');

        $this->_options = array_merge(array(
            'base_url'     => '',
            'project_name' => '',
            'project_dir'  => '',
            'db_user'      => 'root',
            'db_pass'      => 'toor',
        ), $options);

        foreach ($required_keys as $key) {
            if (!isset($this->_options[$key]) || empty($this->_options[$key])) {
                throw new \Exception("Required option '$key' is missing'");
            }
        }
    }

    protected function _getCleanVersion() {
        return str_replace(".", "_", $this->getVersion());
    }

    protected function _getOpt($key) {
        if (isset($this->_options[$key])) {
            return $this->_options[$key];
        } else {
            throw new \Exception("Option $key value not provided");
        }
    }

    /**
     * @see http://stackoverflow.com/a/1707859/283844
     * @return string
     */
    protected function _getTemporaryDirectory() {
        $tempfile=tempnam(sys_get_temp_dir(),'');

        if (file_exists($tempfile)) {
            unlink($tempfile);
        }

        mkdir($tempfile);

        if (is_dir($tempfile)) {
            return $tempfile;
        }
    }

    public function run() {
        $commands = $this->getCommands();

        foreach ($commands as $command) {
            $command->run();
        }
    }
}
