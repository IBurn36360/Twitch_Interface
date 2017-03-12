<?php

date_default_timezone_set('UTC');

// Set our constants to the global env for travis if env exists
if (getenv('TWITCH_TEST_CLIENT_ID') !== false) {
    define('TWITCH_TEST_CLIENT_ID', getenv('TWITCH_TEST_CLIENT_ID'));
}

if (getenv('TWITCH_TEST_CLIENT_SECRET') !== false) {
    define('TWITCH_TEST_CLIENT_SECRET', getenv('TWITCH_TEST_CLIENT_SECRET'));
}

// Run the composer autoload
require_once(__DIR__ . '/../vendor/autoload.php');
