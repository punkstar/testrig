<?php

namespace Meanbee\Testrig\CommandSet;

class Magento1702 extends Magento {
    public function getVersion() {
        return "1.7.0.2";
    }

    public function getUrl() {
        return "http://www.magentocommerce.com/downloads/assets/1.7.0.2/magento-1.7.0.2.tar.gz";
    }

    public function getProjectDirectory() {
        return $this->_getOpt('project_dir') . DIRECTORY_SEPARATOR . $this->_getCleanVersion();
    }

    public function getCommands() {
        $temporary_directory = $this->_getTemporaryDirectory();
        $temporary_gz_file = sprintf("%s/%s.tar.gz", $temporary_directory, $this->getVersion());

        $project_name = $this->_getOpt('project_name');
        $project_directory = $this->getProjectDirectory();
        $project_temp_directory = rtrim($project_directory, '/') . '_temp';

        $db_name = sprintf('test_%s_%s', $project_name, $this->_getCleanVersion());
        $db_user = $this->_getOpt('db_user');
        $db_pass = $this->_getOpt('db_pass');

        $base_url = $this->_getOpt('base_url');

        return array(
            new \Meanbee\Testrig\Command\Mkdir($temporary_directory, 'Making a temporary directory'),
            new \Meanbee\Testrig\Command\Fetch($this->getUrl(), $temporary_gz_file, 'Fetching Magento 1.7.0.2'),

            new \Meanbee\Testrig\Command\Mkdir($project_temp_directory, 'Making temporary project directory'),
            new \Meanbee\Testrig\Command\Gunzip($temporary_gz_file, $project_temp_directory, 'Decompressing'),

            new \Meanbee\Testrig\Command\Mkdir($project_directory, 'Making project directory'),
            new \Meanbee\Testrig\Command\Move($project_temp_directory . '/magento/*', $project_directory, 'Moving to correct place'),
            new \Meanbee\Testrig\Command\Move($project_temp_directory . '/magento/.htaccess*', $project_directory, 'Moving to correct place (dot files)'),

            new \Meanbee\Testrig\Command\MakeDB($db_name, $db_user, $db_pass),

            new \Meanbee\Testrig\Command\Raw("chmod -R 0777 $project_directory/media $project_directory/app/etc $project_directory/var", "Setting correct directory permissions"),

            new \Meanbee\Testrig\Command\MagentoInstall(
                $project_directory,
                $db_name,
                $db_user,
                $db_pass,
                $base_url
            )
        );
    }
}
