<?php

namespace Modules;

use IBurn36360\TwitchInterface\Twitch;
use IBurn36360\TwitchInterface\Configuration;
use IBurn36360\TwitchInterface\Modules\Ingests;

class IngestsTest extends \PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Ingests();
    }

    public function testCanBeUsedThroughAPIMethod() {
        $twitchClient = new Twitch(new Configuration(array(
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true
        )));

        $this->assertTrue(is_object($twitchClient->api('/ingests', array())));
    }

    /**
     * @medium
     */
    public function testCanBeUsedStatically() {
        $this->assertTrue(is_object(Ingests::runGetIngestServers(array(), new Configuration(array(
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true
        )))));
    }
}
