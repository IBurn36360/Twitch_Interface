<?php

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;

/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 9:11 PM
 */
class TwitchTest extends PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID
        ]));
    }
}
