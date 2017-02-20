<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 11:16 PM
 */

namespace Modules;


use IBurn36360\TwitchInterface\Modules\Search;


class SearchTest extends \PHPUnit_Framework_TestCase {
    public function testNamespaceAutoload() {
        new Search();
    }
}
