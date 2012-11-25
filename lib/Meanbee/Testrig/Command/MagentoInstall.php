<?php

namespace Meanbee\Testrig\Command;

class MagentoInstall extends Base {
    protected $_directory = null;

    public function __construct($directory, $description = null) {
        parent::__construct();

        $this->_directory = $directory;

        if (null == $description) {
            $this->_description = "Installing Magento";
        } else {
            $this->_description = $description;
        }
    }

    public function getDescription() {
        return "Installing Magento";
    }

    public function getCommand() {
        $arguments = array(
            'license_agreement_accepted' => 1,
            'locale' => 'en_US',
            'timezone' => 'UTC',
            'default_currency' => 'GBP',
            'db_host' => 'localhost',
            'db_name' => 'test_shippingrules_1702',
            'db_user' => 'root',
            'db_pass' => 'toor',
            'url' => 'http://bartley.local:8888/test/shippingrules/1.7/',
            'secure_base_url' => 'http://bartley.local:8888/test/shippingrules/1.7/',
            'use_rewrites' => 0,
            'use_secure' => 0,
            'use_secure_admin' => 1,
            'admin_firstname' => 'Nick',
            'admin_lastname' => 'Jones',
            'admin_email' => 'nick.jones@meanbee.com',
            'admin_username' => 'admin',
            'admin_password' => 'password1'
        );

        $arg_str = '';
        foreach ($arguments as $key => $value) {
            $arg_str .= sprintf(" --%s %s", $key, $value);
        }

        return sprintf("php -f %s/install.php -- %s", $this->_directory, $arg_str);
    }
}
