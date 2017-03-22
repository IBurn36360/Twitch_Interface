<?php

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
    public function namespaceAutoload() {
        new Configuration(array(
            'clientID' => TWITCH_TEST_CLIENT_ID
        ));
    }

    /**
     * Tests to ensure a Client ID is forced for a valid configuration
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @expectedException IBurn36360\TwitchInterface\Exception\IncompleteConfigurationException
     *
     * @small
     */
    public function requiresClientID() {
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
    public function configurationIsReadable() {
        $configuration = new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID
        ]);

        foreach ([
            'TIBuild',
            'twitchAPIHost',
            'twitchAPIAcceptHeader',
            'applicationClientID',
            'applicationClientSecret',
            'useCABundle',
        ] as $propertyName) {
            $configuration->{$propertyName};
        }
    }

    /**
     * Tests to ensure the configuration is not writable
     *
     * @author Anthony 'IBurn36360' Diaz
     *
     * @test
     *
     * @expectedException IBurn36360\TwitchInterface\Exception\CannotWriteToConfigurationException
     *
     * @small
     */
    public function configurationIsNotWritable() {
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
     * @expectedException IBurn36360\TwitchInterface\Exception\UnknownPropertyException
     *
     * @small
     */
    public function fetchingInvalidPropertiesThrows() {
        $configuration = new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID
        ]);

        $configuration->invalidProperty;
    }
}
