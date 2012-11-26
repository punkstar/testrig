<?php

namespace Meanbee\Testrig\CommandSet;

abstract class Magento {
    abstract public function getVersion();

    public function __construct($options = array()) {
        $required_keys = array('base_url', 'project_name', 'project_dir');

        $this->_options = array_merge(array(
            'base_url'     => '',
            'project_name' => '',
            'project_dir'  => '',
            'db_user'      => 'root',
            'db_pass'      => 'toor',
            'sample'       => false,
            'extensions'   => array()
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

    public function getProjectDirectory() {
        return $this->_getOpt('project_dir') . DIRECTORY_SEPARATOR . $this->_getCleanVersion();
    }

    public function getBaseUrl() {
        return $this->_getOpt('base_url') . '/' . $this->_getCleanVersion();
    }

    public function getUrl() {
        return sprintf("http://www.magentocommerce.com/downloads/assets/%s/magento-%s.tar.gz", $this->getVersion(), $this->getVersion());
    }

    public function getCommands() {
        $temporary_directory = $this->_getTemporaryDirectory();
        $temporary_gz_file = sprintf("%s/%s.tar.gz", $temporary_directory, $this->getVersion());

        $project_name = $this->_getOpt('project_name');
        $project_directory = $this->getProjectDirectory();
        $project_temp_directory = rtrim($project_directory, '/') . '_temp';

        $db_name = str_replace('-', '_', sprintf('test_%s_%s', $project_name, $this->_getCleanVersion()));
        $db_user = $this->_getOpt('db_user');
        $db_pass = $this->_getOpt('db_pass');

        $base_url = $this->getBaseUrl();

        $commands = array(
            new \Meanbee\Testrig\Command\Mkdir($temporary_directory, 'Making a temporary directory'),
            new \Meanbee\Testrig\Command\Fetch($this->getUrl(), $temporary_gz_file, 'Fetching Magento ' . $this->getVersion()),

            new \Meanbee\Testrig\Command\Mkdir($project_temp_directory, 'Making temporary project directory'),
            new \Meanbee\Testrig\Command\Gunzip($temporary_gz_file, $project_temp_directory, 'Decompressing'),

            new \Meanbee\Testrig\Command\Mkdir($project_directory, 'Making project directory'),
            new \Meanbee\Testrig\Command\Move($project_temp_directory . '/magento/*', $project_directory, 'Moving to correct place'),
            new \Meanbee\Testrig\Command\Move($project_temp_directory . '/magento/.htaccess*', $project_directory, 'Moving to correct place (dot files)'),

            new \Meanbee\Testrig\Command\MakeDB($db_name, $db_user, $db_pass),

            new \Meanbee\Testrig\Command\Raw("php -f $project_directory/install.php > /dev/null", "Touching install script (no idea why we need to do this)"),
        );

        if ($this->_getOpt('sample')) {
            $temporary_sample_file = sprintf("%s/sample.tar.gz", $temporary_directory);
            $temporary_sample_dir = $temporary_directory . DIRECTORY_SEPARATOR . 'sample_data';

            $commands[] = new \Meanbee\Testrig\Command\Fetch('http://www.magentocommerce.com/downloads/assets/1.6.1.0/magento-sample-data-1.6.1.0.tar.gz', $temporary_sample_file, 'Fetching sample data');
            $commands[] = new \Meanbee\Testrig\Command\Mkdir($temporary_sample_dir, 'Making temporary sample data directory');
            $commands[] = new \Meanbee\Testrig\Command\Gunzip($temporary_sample_file, $temporary_sample_dir, 'Decompressing sample data');

            // Moving media directory
            $temporary_sample_media_dir = $temporary_sample_dir . DIRECTORY_SEPARATOR . 'magento-sample-data-1.6.1.0' . DIRECTORY_SEPARATOR .  'media';
            $commands[] = new \Meanbee\Testrig\Command\Move($temporary_sample_media_dir, $project_directory . DIRECTORY_SEPARATOR . 'media');

            // Run SQL
            $temporary_sample_file_sql = $temporary_sample_dir . DIRECTORY_SEPARATOR . 'magento-sample-data-1.6.1.0' . DIRECTORY_SEPARATOR . 'magento_sample_data_for_1.6.1.0.sql';
            $commands[] = new \Meanbee\Testrig\Command\Raw(sprintf("mysql -u %s -p%s %s < %s", $db_user, $db_pass, $db_name, $temporary_sample_file_sql));
        }


        $commands[] = new \Meanbee\Testrig\Command\Raw("chmod -R 0777 $project_directory/*", "Setting correct directory permissions");
        $commands[] = new \Meanbee\Testrig\Command\MagentoInstall(
            $project_directory,
            $db_name,
            $db_user,
            $db_pass,
            $base_url
        );

        $extensions = $this->_getOpt('extensions');
        if (count($extensions) > 0) {
            $commands[] = new \Meanbee\Testrig\Command\Raw("cd $project_directory && modman init", "Initialising modman");

            foreach ($extensions as $extension) {
                $commands[] = new \Meanbee\Testrig\Command\Raw("cd $project_directory && modman clone $extension", "Cloning $extension");
            }

            $commands[] = new \Meanbee\Testrig\Command\Raw("cd $project_directory && modman deploy-all", "Cloning $extension");
        }

        return $commands;
    }

    public function run() {
        $commands = $this->getCommands();

        foreach ($commands as $command) {
            $command->run();
        }
    }
}
