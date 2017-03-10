<?php

namespace IBurn36360\TwitchInterface\Exception;

/**
 * Defines an unknown property exception
 *
 * @package IBurn36360\TwitchInterface\Exception
 */
class UnknownPropertyException extends Exception {
    /**
     * UnknownEndpointException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "The requested property is not known", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
