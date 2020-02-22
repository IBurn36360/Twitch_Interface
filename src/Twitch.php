<?php

namespace IBurn36360\TwitchInterface;

use \GuzzleHttp\Client;
use \IBurn36360\TwitchInterface\Exception;
use \IBurn36360\TwitchInterface\Modules\APIGroup;

/**
 * An API wrapper designed to make querying Twitch's V5 Kraken API simple
 *
 * @package IBurn36360\TwitchInterface
 */
final class Twitch {
    private $configuration;

    /**
     * @var APIGroup[]
     */
    private $instancedModules = [];

    public static $pathToModuleAliases = [
        // Bits
        '/bits/cheermotes' => ['Bits', 'getCheermotes'],

        // Games
        '/games/top' => ['Games', 'getTopGames'],

        // Ingests
        '/ingests' => ['Ingests', 'getIngestServers'],

        // Ingests
        '/team' =>  ['Teams', 'getTeam'],
        '/teams' => ['Teams', 'getTeams'],

        // Search
        '/search/channels' => ['Search', 'channels'],
        '/search/games'    => ['Search', 'games'],
        '/search/streams'  => ['Search', 'streams'],
    ];

    private $client;

    /**
     * Twitch constructor.
     *
     * @param Configuration $configuration
     */
    public function __construct(Configuration $configuration) {
        $this->configuration = $configuration;

        // Run an internal client for people using this an an object
        $this->client = new Client([
            'base_uri' => $configuration->twitchAPIHost,
        ]);

        // Build the modules
        $modulesList = glob(__DIR__ . '/Modules/*.php');

        foreach ($modulesList as $module) {
            $module = str_replace(__DIR__ . '/Modules/', '', $module);

            if ($module !== 'ModuleBase.php') {
                $moduleName = str_replace('.php', '', $module);
                $className = '\\IBurn36360\\TwitchInterface\\Modules\\' . $moduleName;

                $this->instancedModules[$moduleName] = new $className();
            }
        }
    }

    /**
     * Runs an API call by its path alias
     *
     * @param       $requestPath
     * @param array $parameters
     *
     * @return mixed
     *
     * @throws Exception\UnknownModuleException
     */
    public function api(string $requestPath, array $parameters = []) {
        if (array_key_exists($requestPath, self::$pathToModuleAliases)) {
            return $this->instancedModules[self::$pathToModuleAliases[$requestPath][0]]->handleCall(
                self::$pathToModuleAliases[$requestPath][1],
                $parameters,
                $this->configuration
            );
        }

        throw new Exception\UnknownModuleException();
    }

    /**
     * Constructs the base request headers for any request heading to Twitch
     *
     * @param Configuration $configuration - The constructed configuration to use for this client instance
     *
     * @return array $headers - The array of headers to work with or pass to Guzzle
     */
    public static function buildRequestHeaders(Configuration $configuration):array {
        return [
            'Accept' => $configuration->twitchAPIAcceptHeader,
            'Client-ID' => $configuration->applicationClientID,
            'User-Agent' => 'PHP ' . PHP_VERSION . " - \\IBurn36360\\Twitch-Interface v{$configuration->TIBuild}",
        ];
    }

    public static function generateOAuthToken() {

    }

    public static function handleCursorIteration() {

    }
}
