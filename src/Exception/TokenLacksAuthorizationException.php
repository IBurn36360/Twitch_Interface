<?php

namespace IBurn36360\TwitchInterface\Exception;

/**
 * Defines a token lacks authorization exception
 *
 * @package IBurn36360\TwitchInterface\Exception
 */
class TokenLacksAuthorizationException extends Exception {
    /**
     * TokenLacksAuthorizationException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "The token provided does not have the required authorization for the API endpoint", $code = 0, \Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
