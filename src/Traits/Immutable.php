<?php

namespace IBurn36360\TwitchInterface\Traits;

use \IBurn36360\TwitchInterface\Exception\CannotFetchUnknownPropertyException;
use \IBurn36360\TwitchInterface\Exception\CannotSetImmutablePropertyException;

/**
 * Class Immutable
 *
 * @package IBurn36360\TwitchInterface\Traits
 */
trait Immutable {
    /**
     * Magic Getter on Immutable objects
     *
     * @param $name
     * @param $value
     *
     * @throws CannotSetImmutablePropertyException
     */
    public function __set($name, $value) {
        throw new CannotSetImmutablePropertyException("You cannot set the value if [{$name}]");
    }

    /**
     * Magic setter on Immutable objects
     *
     * @param $name
     *
     * @return mixed
     *
     * @throws CannotFetchUnknownPropertyException
     */
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->{$name};
        }

        throw new CannotFetchUnknownPropertyException("You cannot fetch the unknown property [{$name}]");
    }
}
