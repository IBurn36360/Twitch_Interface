<?php

namespace IBurn36360\TwitchInterface\Exception;

/**
 * Defines a cannot write to configuration exception
 *
 * @package IBurn36360\TwitchInterface\Exception
 */
class CannotWriteToConfigurationException extends Exception {
    /**
     * CannotWriteToConfigurationException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "You may not attempt to write to a constructed configuration", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
