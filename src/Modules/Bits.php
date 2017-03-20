<?php

namespace IBurn36360\TwitchInterface\Modules;

use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Exception\APIRequestFailureException;
use \IBurn36360\TwitchInterface\Exception\Exception;
use \IBurn36360\TwitchInterface\Twitch;
use \GuzzleHttp\Client;

/**
 * Handles bits related API requests
 *
 * @package IBurn36360\TwitchInterface\Modules
 */
final class Bits
    extends ModuleBase {
    /**
     * Fetches the cheermotes for a channel, or the default cheermotes if no channel is provided
     *
     * @param Configuration $configuration
     * @param array         $parameters
     * @param Client|null   $client
     *
     * @return mixed
     * @throws APIRequestFailureException
     */
    public static function getCheermotes(Configuration $configuration, $parameters = [], Client $client = null) {
        if (is_null($client)) {
            $client = new Client([
                'base_uri' => $configuration->twitchAPIHost,
            ]);
        }

        $cleanedParams = [];

        if (isset($parameters['channelID'])) {
            // String casting will be done later, so no need for sanitization for the request
            $cleanedParams = $parameters['channelID'];
        }

        try {
            $response = $client->request('GET', '/kraken/bits/actions', [
                'headers' => Twitch::buildRequestHeaders($configuration),
                'verify'  => (($configuration->useCABundle) ? __DIR__ . '/../../CABundle.pem' : true),
                'query'   => $cleanedParams,
            ]);

            if ($responseBody = $response->getBody()) {
                return json_decode($responseBody, $configuration->returnType);
            }

            throw new APIRequestFailureException('The API response did not contain a body!');
        } catch (\Exception $exception) {
            throw new APIRequestFailureException('The API request failed', Exception::REQUEST_FAILURE, $exception);
        }
    }
}
