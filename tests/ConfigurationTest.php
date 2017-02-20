<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 9:11 PM
 */


use IBurn36360\TwitchInterface\Configuration;


class ConfigurationTest extends PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Configuration();
    }
}
