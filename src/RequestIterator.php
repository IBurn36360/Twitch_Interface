<?php

namespace IBurn36360\TwitchInterface;

use \IBurn36360\TwitchInterface\Configuration;
use \GuzzleHttp\Client;

/**
 * Handles iterating properly over large requests
 *
 * @package IBurn36360\TwitchInterface
 */
final class RequestIterator {
    /**
     * Iterates over an API request for simply grabbing very large requests
     *
     * @param                                           $APIEndpoint
     * @param                                           $parameters
     * @param \IBurn36360\TwitchInterface\Configuration $configuration
     * @param Client|null                               $client
     */
    public static function iterateOverRequest($APIEndpoint, $parameters, Configuration $configuration, Client $client = null) {

    }
}
