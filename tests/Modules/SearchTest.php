<?php

namespace Modules;

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Search;
use \PHPUnit\Framework\TestCase;

/**
 * Test runner for the search API module
 *
 * Class IngestsTest
 *
 * @package Search
 */
class SearchTest extends TestCase {
    /**
     * Tests namespace autoloading for the module
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @small
     *
     * @test
     */
    public function namespaceAutoload() {
        new Search();
    }

    /**
     * Tests that channels search can be used statically
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @small
     *
     * @test
     */
    public function channelsSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::channels(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]), [
            'query' => 'minecraft'
        ])));
    }

    /**
     * Tests that games search can be used statically
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @small
     *
     * @test
     */
    public function gamesSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::games(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]), [
            'query' => 'minecraft'
        ])));
    }

    /**
     * Tests that streams search can be used statically
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @small
     *
     * @test
     */
    public function streamsSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::streams(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]), [
            'query' => 'minecraft'
        ])));
    }

    /**
     * Tests that channels search can be used through the API method
     *
     * @author Anthony 'IBurn36360' Diaz
     *
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
     * Tests the games search can be used through the API method
     *
     * @author Anthony 'IBurn36360' Diaz
     *
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
     * Tests that streams search can be used through the API method
     *
     * @author Anthony 'IBurn36360' Diaz
     *
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
