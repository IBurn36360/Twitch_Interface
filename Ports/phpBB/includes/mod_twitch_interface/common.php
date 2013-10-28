<?php
/**
 * This is the common file for the phpBB port of Anthony 'IBurn36360' Diaz's
 * Twitch_Interface.  This file and all other files are provided and are protected 
 * by the following license:
 * 
 * This Twitch Interface is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This Twitch Interface is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * A copy of the GNU GPLV3 license can be found at http://www.gnu.org/licenses/
 * or can be found in the folder distributed with the software.
 * 
 */ 

// Start, are we in phpBB?
if (!defined('IN_PHPBB'))
{
    exit;
}

// Assume we installed properly and set all of our database constants here
define('MOD-TWITCH_INTERFACE-CONFIG',          $table_prefix . 'mod-twitch_interface-config');          // Configuration information (Overrides the defauls in the file)
define('MOD-TWITCH_INTERFACE-OUTPUT_LOG',      $table_prefix . 'mod-twitch_interface-output_log');      // The output log from the interface
define('MOD-TWITCH_INTERFACE-ERROR_LOG',       $table_prefix . 'mod-twitch_interface-error_log');       // The error log from the interface
define('MOD-TWITCH_INTERFACE-LIVE_CACHE',      $table_prefix . 'mod-twitch_interface-live_cache');      // The live channel cache from the interface
define('MOD-TWITCH_INTERFACE-CODE_CACHE',      $table_prefix . 'mod-twitch_interface-code_cache');      // The auth code cache from the interface (Works on user ID)

// Include the interface structure
require('./interface_compat.php'); // Builds the compatability with the interface calls to phpBB
require('./interface.php');        // The base interface itself, is short circuited to stop errors

// Now grab our config data


?>