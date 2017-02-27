<?php

namespace IBurn36360\TwitchInterface\Modules;

use \IBurn36360\TwitchInterface\Exception as ModuleException;

/**
 * Base class for API modules
 *
 * Class ModuleBase
 *
 * @package IBurn36360\TwitchInterface\Modules
 */
class ModuleBase {
    /**
     * Handles running a call request from the API wrapper instance
     *
     * @param $functionName
     * @param $parameters
     * @param $configuration
     *
     * @return mixed
     * @throws ModuleException\UnknownEndpointException
     */
    public function handleCall($functionName, $parameters, $configuration) {
        $endpoint = $functionName;

        if (method_exists($this, $endpoint)) {
            return $this::{$endpoint}($parameters, $configuration);
        }

        throw new ModuleException\UnknownEndpointException();
    }
}
