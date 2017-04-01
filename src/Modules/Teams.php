<?php

namespace IBurn36360\TwitchInterface\Modules;

use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Exception\APIRequestFailureException;
use \IBurn36360\TwitchInterface\Exception\Exception;
use \IBurn36360\TwitchInterface\Twitch;
use \GuzzleHttp\Client;

/**
 * Handles teams requests
 *
 * @package IBurn36360\TwitchInterface\Modules
 */
final class Teams
    extends ModuleBase {
    /**
     * Fetches a list of active teams from the API
     *
     * @param Configuration $configuration
     * @param array         $parameters
     * @param Client|null   $client
     *
     * @return mixed
     * @throws APIRequestFailureException
     */
    public static function getTeams(Configuration $configuration, $parameters = [], Client $client = null) {
        $cleanedParams = [];

        if (isset($parameters['limit']) && ($parameters['limit'] = intval($parameters['limit']))) {
            $cleanedParams['limit'] = $parameters['limit'];
        }

        if (isset($parameters['offset']) && ($parameters['offset'] = intval($parameters['offset']))) {
            $cleanedParams['offset'] = $parameters['offset'];
        }

        // Make the call now
        if (is_null($client)) {
            $client = new Client([
                'base_uri' => $configuration->twitchAPIHost,
            ]);
        }

        try {
            $response = $client->request('GET', '/kraken/teams', [
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

    /**
     * Fetches a team by name
     *
     * @param Configuration $configuration
     * @param array         $parameters
     * @param Client|null   $client
     *
     * @return mixed
     * @throws APIRequestFailureException
     */
    public static function getTeam(Configuration $configuration, $parameters = [], Client $client = null) {
        if (!($parameters['teamName'] = trim($parameters['teamName']))) {
            throw new InvalidParameterException('You must provide a team name in order to fetch the team object');
        }

        // Make the call now
        if (is_null($client)) {
            $client = new Client([
                'base_uri' => $configuration->twitchAPIHost,
            ]);
        }

        try {
            $response = $client->request('GET', '/kraken/teams/' . $parameters['teamName'], [
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
