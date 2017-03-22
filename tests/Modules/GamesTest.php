<?php

namespace Modules;

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Games;
use \PHPUnit\Framework\TestCase;

/**
 * Test runner for the games API module
 *
 * @package Modules
 */
class GamesTest extends TestCase {
    /**
     * Tests namespace autoloading for the module
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function namespaceAutoload() {
        new Games();
    }

    /**
     * Validates that the getTopGames API endpoint may be used through the API instance
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function canBeUsedThroughAPIMethod() {
        $twitchClient = new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]));

        $this->assertTrue(is_object($twitchClient->api('/games/top')));
    }

    /**
     * Validates that the getTopGames API endpoint may be used statically
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function canBeUsedStatically() {
        $this->assertTrue(is_object(Games::getTopGames(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }
}
