<?php
$autoloadPath = realpath(__DIR__ . "/../vendor/autoload.php");

if (!$autoloadPath) { // If inside of vendor dir
    $autoloadPath =  realpath(__DIR__ . "/../../../autoload.php");
}

require $autoloadPath;