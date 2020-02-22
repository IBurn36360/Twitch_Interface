<?php

namespace IBurn36360\TwitchInterface;

use \IBurn36360\TwitchInterface\Exception\IncompleteConfigurationException;
use \IBurn36360\TwitchInterface\Traits\Immutable;

/**
 * Constructs a new Twitch Interface configuration instance
 *
 * @package IBurn36360\TwitchInterface
 *
 * @property-read string $TIBuild
 * @property-read string $twitchAPIHost
 * @property-read string $twitchAPIAcceptHeader
 * @property-read bool $returnType
 * @property-read string $applicationClientID
 * @property-read string $applicationClientSecret
 */
final class Configuration {
    use Immutable;

    public const RETURN_TYPE_OBJECT = false;

    public const RETURN_TYPE_ASSOC_ARRAY = true;

    /**
     * @var string $TIBuild
     */
    private $TIBuild = '2.0.0.0';

    /**
     * @var string $twitchAPIHost
     */
    private $twitchAPIHost = 'https://api.twitch.tv';

    /**
     * @var string $twitchAPIAcceptHeader
     */
    private $twitchAPIAcceptHeader = 'application/vnd.twitchtv.v5+json';

    /**
     * @var bool $returnType
     */
    private $returnType;

    /**
     * @var mixed $applicationClientID
     */
    private $applicationClientID;

    /**
     * @var mixed $applicationClientSecret
     */
    private $applicationClientSecret;

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

        if (isset($configurationOptions['returnType']) && !empty($configurationOptions['returnType'])) {
            $this->returnType = (((bool)$configurationOptions['returnArray']) ? self::RETURN_TYPE_ASSOC_ARRAY : self::RETURN_TYPE_OBJECT);
        }
    }
}
