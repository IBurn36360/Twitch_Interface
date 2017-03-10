<?php

namespace IBurn36360\TwitchInterface\Exception;

/**
 * Defines an invalid parameter exception
 *
 * @package IBurn36360\TwitchInterface\Exception
 */
class InvalidParameterException extends Exception {
    /**
     * InvalidParameterException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "The parameters provided were not valid", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
