<?php

namespace IBurn36360\TwitchInterface\Modules;

use \IBurn36360\TwitchInterface\Exception as ModuleException;

class ModuleBase {
    public function handleCall($endpoint, $parameters, $configuration, $token = null) {
        $endpoint = 'run' . ucfirst($endpoint);

        if (method_exists(get_class(), $endpoint)) {
            return $this->{$endpoint}($parameters, $configuration, $token);
        }

        throw new ModuleException\UnknownEndpointException();
    }
}
