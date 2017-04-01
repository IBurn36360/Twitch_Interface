<?php

namespace Modules;

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Teams;
use \PHPUnit\Framework\TestCase;

/**
 * Test runner for the teams API module
 *
 * Class TeamsTest
 *
 * @package Teams
 */
class TeamsTest extends TestCase {
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
        new Teams();
    }

    /**
     * Validates that the getTeams API endpoint may be used through the API method
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @medium
     */
    public function teamsListCanBeUsedThroughAPIMethod() {
        $twitchClient = new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]));

        $this->assertTrue(is_object($twitchClient->api('/teams')));
    }

    /**
     * Validates that the getTeams API endpoint may be used statically
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @medium
     */
    public function teamsListCanBeUsedStatically() {
        $this->assertTrue(is_object(Teams::getTeams(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }

    /**
     * Validates that the getTeams API endpoint may be used through the API method
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function fetchTeamCanBeUsedThroughAPIMethod() {
        $twitchClient = new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]));

        $this->assertTrue(is_object($twitchClient->api('/team', [
            'teamName' => 'staff'
        ])));
    }

    /**
     * Validates that the getTeams API endpoint may be used statically
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function fetchTeamCanBeUsedStatically() {
        $this->assertTrue(is_object(Teams::getTeam(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]), [
            'teamName' => 'staff'
        ])));
    }
}
