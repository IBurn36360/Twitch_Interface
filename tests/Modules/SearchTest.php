<?php

namespace Modules;

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Search;

/**
 * Test runner for the search API module
 *
 * Class IngestsTest
 *
 * @package Search
 */
class SearchTest extends \PHPUnit_Framework_TestCase {
    /**
     * Tests namespace autoloading for the module
     *
     * @small
     *
     * @test
     */
    public function namespaceAutoload() {
        new Search();
    }

    /**
     * @small
     *
     * @test
     */
    public function channelsSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::channels([
            'query' => 'minecraft'
        ], new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }

    /**
     * @small
     *
     * @test
     */
    public function gamesSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::games([
            'query' => 'minecraft'
        ], new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }

    /**
     * @small
     *
     * @test
     */
    public function streamsSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::streams([
            'query' => 'minecraft'
        ], new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }

    /**
     * @small
     *
     * @test
     */
    public function channelsSearchCanBeUsedThroughAPIMethod() {
        $twitchClient = new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]));

        $this->assertTrue(is_object($twitchClient->api('/search/channels', [
            'query' => 'minecraft'
        ])));
    }

    /**
     * @small
     *
     * @test
     */
    public function gamesSearchCanBeUsedThroughAPIMethod() {
        $twitchClient = new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]));

        $this->assertTrue(is_object($twitchClient->api('/search/games', [
            'query' => 'minecraft'
        ])));
    }

    /**
     * @small
     *
     * @test
     */
    public function streamsSearchCanBeUsedThroughAPIMethod() {
        $twitchClient = new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]));

        $this->assertTrue(is_object($twitchClient->api('/search/streams', [
            'query' => 'minecraft'
        ])));
    }
}
