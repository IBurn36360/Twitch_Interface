<?php

namespace IBurn36360\TwitchInterface\Exception;

/**
 * Defines an API request failure exception
 *
 * @package IBurn36360\TwitchInterface\Exception
 */
class APIRequestFailureException extends Exception {
    /**
     * APIRequestFailureException constructor.
     *
     * @param string         $message
     * @param int            $code
     * @param Exception|null $previous
     */
    public function __construct($message = "The API request failed", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
