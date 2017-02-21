<?php

namespace IBurn36360\TwitchInterface\Modules;

use \IBurn36360\TwitchInterface\Configuration;
use \GuzzleHttp\Client;
use IBurn36360\TwitchInterface\Exception\APIRequestFailureException;
use \IBurn36360\TwitchInterface\Twitch;

/**
 * Class Ingests
 *
 * @package IBurn36360\TwitchInterface\Modules
 */
class Ingests
    extends ModuleBase {
    /**
     * @param               $parameters
     * @param Configuration $configuration
     * @param Client|null   $client
     *
     * @return mixed
     * @throws APIRequestFailureException
     */
    public static function runGetIngestServers($parameters, Configuration $configuration, Client $client = null) {
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
                return json_decode($responseBody);
            }
        } catch (\Exception $exception) { }

        throw new APIRequestFailureException();
    }
}
