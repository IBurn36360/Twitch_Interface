<?php

namespace Modules;

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Ingests;

/**
 * Test runner for the ingests API module
 *
 * Class IngestsTest
 *
 * @package Modules
 */
class IngestsTest extends \PHPUnit_Framework_TestCase {
    /**
     * Tests namespace autoloading for the module
     *
     * @small
     */
    public function testNamespaceAutoload() {
        new Ingests();
    }

    /**
     * Validates that the getIngests API endpoint may be used through the API instance
     *
     * @small
     */
    public function testCanBeUsedThroughAPIMethod() {
        $twitchClient = new Twitch(new Configuration(array(
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        )));

        $this->assertTrue(is_object($twitchClient->api('/ingests')));
    }

    /**
     * Validates that the getIngests API endpoint may be used statically
     *
     * @small
     */
    public function testCanBeUsedStatically() {
        $this->assertTrue(is_object(Ingests::getIngestServers(array(), new Configuration(array(
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        )))));
    }
}
