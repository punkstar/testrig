<?php

namespace Meanbee\Testrig;

class Cli {

    public function getAllowedMagentoVersions() {
        return array(
            '1.7'     => '\Meanbee\Testrig\CommandSet\Magento17',
            '1.7.0.2' => '\Meanbee\Testrig\CommandSet\Magento1702',
            '1.6'     => '\Meanbee\Testrig\CommandSet\Magento16',
            '1.6.2.0' => '\Meanbee\Testrig\CommandSet\Magento1620',
            '1.5'     => '\Meanbee\Testrig\CommandSet\Magento15',
            '1.5.1.0' => '\Meanbee\Testrig\CommandSet\Magento1510'
        );
    }

    public function getOptions() {
        $opts = new \Commando\Command();

        $supported_versions = join(', ', array_keys($this->getAllowedMagentoVersions()));
        $opts->setHelp("Simple installation of Magento versions for testing.
Supported Magento versions: $supported_versions");

        $opts->option('name')
            ->required()
            ->aka('n')
            ->describedAs('Project name');

        $opts->option('dir')
            ->required()
            ->aka('d')
            ->describedAs('Project directory');

        $opts->option('url')
            ->required()
            ->aka('u')
            ->describedAs('Project directory');

        $opts->option('version')
            ->required()
            ->aka('v')
            ->describedAs('Magento version to install')
            ->must(function ($version) {
                return in_array($version, array_keys($this->getAllowedMagentoVersions()));
            });

        $opts->option('db_user')
            ->required()
            ->describedAs('Database username');

        $opts->option('db_pass')
            ->required()
            ->describedAs('Database password');

        return $opts;
    }
}
