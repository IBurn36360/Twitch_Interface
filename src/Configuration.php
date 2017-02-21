<?php

namespace IBurn36360\TwitchInterface;

use \IBurn36360\TwitchInterface\Exception\CannotWriteToConfigurationException;
use \IBurn36360\TwitchInterface\Exception\IncompleteConfigurationException;
use \IBurn36360\TwitchInterface\Exception\UnknownPropertyException;

/**
 * Class Configuration
 *
 * @package IBurn36360\TwitchInterface
 */
final class Configuration {
    const RETURN_TYPE_OBJECT = false;

    const RETURN_TYPE_ASSOC_ARRAY = true;

    private $TIBuild = '2.0.0.0';

    private $twitchAPIHost = 'https://api.twitch.tv';

    private $twitchAPIAcceptHeader = 'application/vnd.twitchtv.v5+json';

    private $returnType;

    private $applicationClientID;

    private $applicationClientSecret;

    private $useCABundle;

    private $CABundlePath =  __DIR__ . '/../CABundle.pem';

    /**
     * Configuration constructor.
     *
     * @param array $configurationOptions - The array of configuration options to apply
     *
     * @throws IncompleteConfigurationException
     */
    public function __construct(array $configurationOptions) {
        if (!isset($configurationOptions['clientID']) || empty($configurationOptions['clientID'])) {
            throw new IncompleteConfigurationException();
        }

        $this->applicationClientID = $configurationOptions['clientID'];

        if (isset($configurationOptions['clientSecret']) && !empty($configurationOptions['clientSecret'])) {
            $this->applicationClientSecret = $configurationOptions['clientSecret'];
        }

        if (isset($configurationOptions['useCABundle']) && !empty($configurationOptions['useCABundle'])) {
            // Force bool
            $this->useCABundle = !!$configurationOptions['useCABundle'];
        }

        if (isset($configurationOptions['returnType']) && !empty($configurationOptions['returnType'])) {
            $this->returnType = ((!!$configurationOptions['clientSecret']) ? self::RETURN_TYPE_ASSOC_ARRAY : self::RETURN_TYPE_OBJECT);
        }
    }

    /**
     * Magic getter for private properties
     *
     * @param $propertyName
     *
     * @return mixed
     * @throws UnknownPropertyException
     */
    public function __get($propertyName) {
        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        throw new UnknownPropertyException();
    }

    /**
     * Magic setter
     *
     * @param $propertyName
     * @param $propertyValue
     *
     * @throws CannotWriteToConfigurationException
     */
    public function __set($propertyName, $propertyValue) {
        throw new CannotWriteToConfigurationException();
    }
}
