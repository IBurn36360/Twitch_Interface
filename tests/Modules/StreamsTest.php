<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 11:17 PM
 */

namespace Modules;


use IBurn36360\TwitchInterface\Modules\Streams;


class StreamsTest extends \PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Streams();
    }
}
