<?php

namespace IBurn36360\TwitchInterface\API\Kraken5;

use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Exception\APIRequestFailureException;
use \IBurn36360\TwitchInterface\Exception\Exception;
use \IBurn36360\TwitchInterface\Exception\InvalidParameterException;
use \IBurn36360\TwitchInterface\Twitch;
use \GuzzleHttp\Client;

/**
 * Class Search
 *
 * @package IBurn36360\TwitchInterface\Modules
 */
final class Search
    extends APIGroup {
    /**
     * Searches for channels based on the provided query
     *
     * @param Configuration $configuration
     * @param array         $parameters
     * @param Client|null   $client
     *
     * @return mixed
     * @throws APIRequestFailureException
     * @throws InvalidParameterException
     */
    public static function channels(Configuration $configuration, $parameters = [], Client $client = null) {
        if (!($parameters['query'] = trim($parameters['query']))) {
            throw new InvalidParameterException('You must provide a query in order to perform a search');
        }

        $cleanedParams = [
            'query' => $parameters['query'],
        ];

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
            $response = $client->request('GET', '/kraken/search/channels', [
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
     * Searches for channels based on the provided query
     *
     * @param Configuration $configuration
     * @param array         $parameters
     * @param Client|null   $client
     *
     * @return mixed
     * @throws APIRequestFailureException
     * @throws InvalidParameterException
     */
    public static function games(Configuration $configuration, $parameters = [], Client $client = null) {
        if (!($parameters['query'] = trim($parameters['query']))) {
            throw new InvalidParameterException('You must provide a query in order to perform a search');
        }

        $cleanedParams = [
            'query' => $parameters['query'],
        ];

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
            $response = $client->request('GET', '/kraken/search/games', [
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
     * Searches for channels based on the provided query
     *
     * @param Configuration $configuration
     * @param array         $parameters
     * @param Client|null   $client
     *
     * @return mixed
     * @throws APIRequestFailureException
     * @throws InvalidParameterException
     */
    public static function streams(Configuration $configuration, $parameters = [], Client $client = null) {
        if (!($parameters['query'] = trim($parameters['query']))) {
            throw new InvalidParameterException('You must provide a query in order to perform a search');
        }

        $cleanedParams = [
            'query' => $parameters['query'],
        ];

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
            $response = $client->request('GET', '/kraken/search/streams', [
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
