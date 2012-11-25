<?php

namespace Meanbee\Testrig\Command;

abstract class Base {
    protected $_argv = array();
    protected $_argc = 0;

    /** @var \Colors\Color */
    protected $_c = null;

    abstract public function getDescription();
    abstract public function getCommand();

    public function __construct() {
        $this->_c = new \Colors\Color();

        $this->_c->setTheme(
            array(
                'command' => 'yellow',
                'message' => 'blue',
                'error'   => 'red'
            )
        );
    }

    public function getColour($text) {
        $colour = $this->_c;
        return $colour($text);
    }

    public function printCommand($text) {
        $colour = $this->_c;
        $text = trim($text);

        echo $colour(sprintf("  $ %s\n", $text))->command;
    }

    public function printMessage($text) {
        $colour = $this->_c;
        $text = trim($text);

        echo $colour(sprintf("%s\n", $text))->message;
    }

    public function printError($text) {
        $colour = $this->_c;
        $text = trim($text);

        echo $colour(sprintf("%s\n", $text))->error;
    }

    public function run() {
        $this->_argv = func_get_args();
        $this->_argc = func_num_args();

        $command = $this->getCommand();

        $this->printMessage(sprintf("Running: %s..", $this->getDescription()));
        $this->printCommand($command);

        $exit_content = array();
        $exit_status = 0;
        exec($command, $exit_content, $exit_status);

        if ($exit_status != 0) {
            $this->printError("Warning, exited with a non-zero status: $exit_status\n");

            if (count($exit_content > 0)) {
                foreach ($exit_content as $line) {
                    $this->printError("\t" . $line);
                }
            }
        }
    }
}
