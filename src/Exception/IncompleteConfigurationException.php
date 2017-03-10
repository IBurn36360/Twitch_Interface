<?php

namespace IBurn36360\TwitchInterface\Exception;

/**
 * Defines an incomplete configuration exception
 *
 * @package IBurn36360\TwitchInterface\Exception
 */
class IncompleteConfigurationException extends Exception {
    /**
     * IncompleteConfigurationException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "The configuration provided is incomplete", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
