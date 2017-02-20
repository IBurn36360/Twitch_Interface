<?php

namespace IBurn36360\TwitchInterface;

final class Configuration {
    private $TIBuild = '2.0.0.0';

    private $twitchAPIHost = 'https://api.twitch.tv';

    public function __get($propertyName) {
        if (property_exists($this, $propertyName)) {
            return $this->{$propertyName};
        }

        throw new \IBurn36360\TwitchInterface\Exception\UnknownPropertyException();
    }
}
