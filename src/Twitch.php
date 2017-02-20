<?php

namespace IBurn36360\TwitchInterface;

use \IBurn36360\TwitchInterface\Exception as Exception;

final class Twitch {
    private $configuration = array();

    private $instancedModules = array();

    public function __construct(Configuration $configuration) {
        // Build the modules
    }

    public function api($module, $endpoint, $parameters = array()) {
        if (array_key_exists($module, $this->instancedModules)) {
            return $this->instancedModules[$module]->handleCall($endpoint, $parameters);
        }

        throw new Exception\UnknownModuleException();
    }
}
