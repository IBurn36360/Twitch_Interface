<?php

namespace Modules;

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Ingests;
use \PHPUnit\Framework\TestCase;

/**
 * Test runner for the ingests API module
 *
 * Class IngestsTest
 *
 * @package Ingests
 */
class IngestsTest extends TestCase {
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
        new Ingests();
    }

    /**
     * Validates that the getIngests API endpoint may be used through the API instance
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

        $this->assertTrue(is_object($twitchClient->api('/ingests')));
    }

    /**
     * Validates that the getIngests API endpoint may be used statically
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function canBeUsedStatically() {
        $this->assertTrue(is_object(Ingests::getIngestServers(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }
}
