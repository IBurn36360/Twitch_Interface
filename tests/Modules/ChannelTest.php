<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 11:09 PM
 */

namespace Modules;


use IBurn36360\TwitchInterface\Modules\Channel;


class ChannelTest extends \PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Channel();
    }
}
