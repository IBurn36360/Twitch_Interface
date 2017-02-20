<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 11:10 PM
 */

namespace Modules;


use IBurn36360\TwitchInterface\Modules\Games;


class GamesTest extends \PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Games();
    }
}
