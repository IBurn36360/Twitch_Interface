<?php
/**
 * Created by PhpStorm.
 * User: Anthony
 * Date: 2/18/2017
 * Time: 11:16 PM
 */

namespace Modules;

use \IBurn36360\TwitchInterface\Twitch;
use \IBurn36360\TwitchInterface\Configuration;
use \IBurn36360\TwitchInterface\Modules\Search;


class SearchTest extends \PHPUnit_Framework_TestCase {
    /**
     * @small
     *
     * @test
     */
    public function namespaceAutoload() {
        new Search();
    }

    /**
     * @small
     *
     * @test
     */
    public function channelsSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::channels([
            'query' => 'minecraft'
        ], new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }

    /**
     * @small
     *
     * @test
     */
    public function gamesSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::games([
            'query' => 'minecraft'
        ], new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }



    /**
     * @small
     *
     * @test
     */
    public function streamsSearchCanBeUsedStatically() {
        $this->assertTrue(is_object(search::streams([
            'query' => 'minecraft'
        ], new Configuration([
            'clientID' => TWITCH_TEST_CLIENT_ID,
            'useCABundle' => true,
        ]))));
    }
}
