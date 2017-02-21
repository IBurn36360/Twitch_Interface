<?php

namespace IBurn36360\TwitchInterface\Modules;

use \IBurn36360\TwitchInterface\Exception as ModuleException;

class ModuleBase {
    public function handleCall($functionName, $parameters, $configuration) {
        $endpoint = 'run' . ucfirst($functionName);

        if (method_exists($this, $endpoint)) {
            return $this::{$endpoint}($parameters, $configuration);
        }

        throw new ModuleException\UnknownEndpointException();
    }
}
