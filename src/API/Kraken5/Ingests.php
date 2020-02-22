<?php

namespace IBurn36360\TwitchInterface\API\Kraken5;

use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Exception\APIRequestFailureException;
use \IBurn36360\TwitchInterface\Exception\Exception;
use \IBurn36360\TwitchInterface\Twitch;
use \GuzzleHttp\Client;

/**
 * Handles ingest server status requests
 *
 * @package IBurn36360\TwitchInterface\Modules
 */
final class Ingests
    extends APIGroup {
    /**
     * Fetches the ingest server availability
     *
     * @param Configuration $configuration
     * @param array         $parameters
     * @param Client|null   $client
     *
     * @return mixed
     * @throws APIRequestFailureException
     */
    public static function getIngestServers(Configuration $configuration, $parameters = [], Client $client = null) {
        if (is_null($client)) {
            $client = new Client([
                'base_uri' => $configuration->twitchAPIHost,
            ]);
        }

        try {
            $response = $client->request('GET', '/kraken/ingests', [
                'headers' => Twitch::buildRequestHeaders($configuration),
                'verify'  => (($configuration->useCABundle) ? __DIR__ . '/../../CABundle.pem' : true),
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
