<?php

namespace Meanbee\Testrig\Command;

class MagentoInstall extends Base {
    protected $_directory = null;

    public function __construct($directory, $db_name, $db_user, $db_pass, $base_url, $description = null) {
        parent::__construct();

        $base_url = preg_replace('#/$#', '', $base_url);

        $this->_directory = $directory;
        $this->_dbname = $db_name;
        $this->_dbuser = $db_user;
        $this->_dbpass = $db_pass;
        $this->_baseurl = $base_url;

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
            'db_name' => $this->_dbname,
            'db_user' => $this->_dbuser,
            'db_pass' => $this->_dbpass,
            'url' => $this->_baseurl,
            'secure_base_url' => $this->_baseurl,
            'use_rewrites' => 1,
            'use_secure' => 0,
            'use_secure_admin' => 1,
            'admin_firstname' => 'Nick',
            'admin_lastname' => 'Jones',
            'admin_email' => 'admin@localhost.com',
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
