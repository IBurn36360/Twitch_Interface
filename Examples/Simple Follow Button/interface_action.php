<?php

/**
 * Listing off the URL and how it is constructed
 * 
 * http://www.test.com/dir/follow.php?action=follow&user=testuser1&chan=testchannel2
 * 
 * Parameters and what they mean
 * 
 * action - follow, unfollow.  What you are trying to do
 * user - username.  username of target ($user)
 * chan - channelname. channel name of subject ($chan)
 */

session_start();
$_SESSION = array();
session_destroy();

$codes = array();
$counter = 0;

// Were we suplied an action?  If not, set to false
$action = (isset($_GET['action'])) ? $_GET['action'] : false;

if (!$action)
{
    echo 'false'; // generic fail
    exit;
}

if (file_exists('./code_storage.php'))
{    
    $arr = file('./code_storage.php');
}

foreach ($arr as $row)
{
    $split = explode(':', $row);
    
    $codes[$split[0]] = $split[1];
}

require('./interface.php');
$interface = new twitch;
array_shift($codes);

if (array_key_exists( $_GET['user'], $codes) == 1)
{
    if ($action == 'follow')
    {
        $success = $interface->followChan($_GET['user'], $_GET['chan'], null, $codes[$_GET['user']]);
        if ($success) // For AJAX return, will state if failed or succeeded
        {
            echo 'true'; 
        } else {
            echo 'false';
        }  
    } elseif ($action == 'unfollow') {
        $success = $interface->unfollowChan($_GET['user'], $_GET['chan'], null, $codes[$_GET['user']]);
        if ($success) // For AJAX return, will state if failed or succeeded
        {
            echo 'true'; 
        } else {
            echo 'false';
        }   
    } 
} else {
    // Handle this in he AJAX.  This SHOULD prolly open up a new tab for the user to auth to.  From there, the follow can be retried as normal without a page reload
    echo 'authorize';
}

// action not within bounds, exit
exit;
?>