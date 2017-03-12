<?php

namespace Modules;

use IBurn36360\TwitchInterface\Modules\Collections;

class CollectionsTest extends \PHPUnit_Framework_TestCase {
    /**
     * Tests namespace autoloading for the module
     *
     * @small
     *
     * @test
     */
    public function namespaceAutoload() {
        new Collections();
    }
}
