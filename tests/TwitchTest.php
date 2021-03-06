<?php

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \PHPUnit\Framework\TestCase;

/**
 * Test runner for the main Twitch class
 *
 * @package Modules
 */
class TwitchTest extends TestCase {
    /**
     * Tests namespace autoloading for the main API class
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function namespaceAutoload():void {
        new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID
        ]));

        $this->assertTrue(true);
    }

    /**
     * Tests that the API method is defined
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function apiMethodDefined():void {
        $twitch = new Twitch(new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID
        ]));

        $this->assertTrue(method_exists($twitch, 'api'));
    }

    /**
     * Tests that the API method is defined
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function staticHeaderBuilderDefined():void {
        $this->assertTrue(method_exists(Twitch::class, 'buildRequestHeaders'));
    }

    /**
     * Tests that the API method is defined
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function staticIteratorHelperDefined():void {
        $this->assertTrue(method_exists(Twitch::class, 'handleCursorIteration'));
    }
}
