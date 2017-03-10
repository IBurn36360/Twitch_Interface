<?php

namespace IBurn36360\TwitchInterface\Exception;

/**
 * Defines an unknown module exception
 *
 * @package IBurn36360\TwitchInterface\Exception
 */
class UnknownModuleException extends Exception {
    /**
     * UnknownEndpointException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "The API module requested is not known", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
