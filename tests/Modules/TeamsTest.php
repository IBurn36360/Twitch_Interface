<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 11:17 PM
 */

namespace Modules;


use IBurn36360\TwitchInterface\Modules\Teams;


class TeamsTest extends \PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Teams();
    }
}
