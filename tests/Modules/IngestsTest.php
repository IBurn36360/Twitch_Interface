<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 11:11 PM
 */

namespace Modules;


use IBurn36360\TwitchInterface\Modules\Ingests;


class IngestsTest extends \PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Ingests();
    }

    public function testIngestsEndpointCanBeInvokedByAPIMethod() {

    }

    public function testIngestsEndpointCanBeInvokedStatically() {

    }
}
