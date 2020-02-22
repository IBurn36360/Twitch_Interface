<?php

namespace IBurn36360\TwitchInterface\Exception;

use \Exception;
use \Throwable;

/**
 * Class CannotFetchUnknownPropertyException
 *
 * @package IBurn36360\TwitchInterface\Exception
 */
final class CannotFetchUnknownPropertyException extends Exception {
    public function __construct($message = '', $code = 0, Throwable $previous = null) {
        parent::__construct($message, $code, $previous);
    }
}
