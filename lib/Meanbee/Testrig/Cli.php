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
            '1.5.1.0' => '\Meanbee\Testrig\CommandSet\Magento1510',
            '1.4'     => '\Meanbee\Testrig\CommandSet\Magento14',
            '1.4.2.0' => '\Meanbee\Testrig\CommandSet\Magento1420'
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
            ->describedAs('Magento version to install (comma-separate multiple versions)')
            ->must(function ($version_string) {
                $versions = explode(',', $version_string);

                foreach ($versions as $version) {
                    $version = trim($version);

                    if (!in_array($version, array_keys($this->getAllowedMagentoVersions()))) {
                        return false;
                    }
                }

                return true;
            })
            ->map(function ($version_string) {
                $versions = explode(',', $version_string);
                $versions_cleaned = array();

                foreach ($versions as $version) {
                    $versions_cleaned[] = trim($version);
                }

                return $versions_cleaned;
            });

        $opts->option('db_user')
            ->required()
            ->describedAs('Database username');

        $opts->option('db_pass')
            ->required()
            ->describedAs('Database password');

        $opts->option('sample')
            ->describedAs('Install sample data')
            ->boolean();

        return $opts;
    }
}
