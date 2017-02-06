<?php

namespace IBurn36360\TwitchInterface;

class Twitch {
    private $configuration = array();

    private $instancedModules = array();

    public function __construct() {
        // Build the modules
    }

    public function api($module, $endpoint, $parameters = array()) {
        if (array_key_exists($module, $this->instancedModules)) {

        }
    }
}
