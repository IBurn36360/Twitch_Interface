<?php

namespace Modules;

use IBurn36360\TwitchInterface\Modules\Streams;

class StreamsTest extends \PHPUnit_Framework_TestCase {
    /**
     * Tests namespace autoloading for the module
     *
     * @small
     *
     * @test
     */
    public function namespaceAutoload() {
        new Streams();
    }
}
