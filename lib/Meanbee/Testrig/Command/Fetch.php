<?php

namespace Meanbee\Testrig\Command;

class Fetch extends Base {
    protected $_cache_dir = null;
    protected $_url = null;
    protected $_output = null;
    protected $_description = null;

    public function __construct($url, $output, $description = null) {
        parent::__construct();

        $this->_cache_dir = getenv('HOME') . DIRECTORY_SEPARATOR . '.testrig_cache';

        $this->_url = $url;
        $this->_output = $output;

        if (null == $description) {
            $this->_description = sprintf("Downloading %s", $url);
        } else {
            $this->_description = $description;
        }
    }

    public function getDescription() {
        return $this->_description;
    }

    public function getCommand() {
        if ($this->_isCached()) {
            return sprintf("cp %s %s", $this->_getCacheFile(), $this->_output);
        } else {
            return sprintf("mkdir -p %s && wget %s -O %s && cp %s %s",  $this->_cache_dir, $this->_url, $this->_getCacheFile(), $this->_getCacheFile(), $this->_output);
        }
    }

    protected function _getCacheKey() {
        return md5($this->_url);
    }

    protected function _getCacheFile() {
        return $this->_cache_dir . DIRECTORY_SEPARATOR . $this->_getCacheKey();
    }

    protected function _isCached() {
        return file_exists($this->_getCacheFile());
    }
}
