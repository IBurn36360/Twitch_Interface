<?php

use \IBurn36360\TwitchInterface\Exception\CannotFetchUnknownPropertyException;
use \IBurn36360\TwitchInterface\Exception\CannotSetImmutablePropertyException;
use \IBurn36360\TwitchInterface\Exception\IncompleteConfigurationException;
use \IBurn36360\TwitchInterface\Configuration;
use \PHPUnit\Framework\TestCase;

/**
 * Test runner for the Configuration class
 *
 * @package Modules
 */
class ConfigurationTest extends TestCase {
    /**
     * Tests namespace autoloading for the configuration
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function namespaceAutoload():void {
        new Configuration(array(
            'clientID' => TWITCH_TEST_CLIENT_ID
        ));

        $this->assertTrue(true);
    }

    /**
     * Tests to ensure a Client ID is forced for a valid configuration
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function requiresClientID():void {
        $this->expectException(IncompleteConfigurationException::class);

        new Configuration(array());
    }

    /**
     * Tests to ensure Client ID is readable
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function configurationIsReadable():void {
        $configuration = new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID
        ]);

        foreach ([
            'TIBuild',
            'twitchAPIHost',
            'twitchAPIAcceptHeader',
            'returnType',
            'applicationClientID',
            'applicationClientSecret',
        ] as $propertyName) {
            $configuration->{$propertyName};
        }

        $this->assertTrue(true);
    }

    /**
     * Tests to ensure the configuration is not writable
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function configurationIsNotWritable() {
        $this->expectException(CannotSetImmutablePropertyException::class);

        $configuration = new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID
        ]);

        $configuration->clientID = false;
    }

    /**
     * Tests to ensure fetching an invalid property throws an exception
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @small
     */
    public function fetchingInvalidPropertiesThrows() {
        $this->expectException(CannotFetchUnknownPropertyException::class);

        $configuration = new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID
        ]);

        $configuration->invalidProperty;
    }
}
