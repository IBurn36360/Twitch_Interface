<?php
/**
 * This is the compatability file for the phpBB port of Anthony 'IBurn36360' Diaz's
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
 */ 
 
class phpBBTwitch // Provides all functions to interact with the interface from phpBB's end
{
    public function postError($errNo, $errStr)
    {
        global $db;
        
        $sql = 'INSERT INTO ' . MOD_TWITCH_INTERFACE_ERROR_LOG . '(\'time\', \'errno\', \'errstr\') VALUES(' . time() . ', ' . $db->sql_escape($errNo) . ', \'' . $db->sql_escape($errStr) . '\');';
        $db->sql_query($sql);
    }
    
    public function postOutput($function, $errStr)
    {
        global $db;
        
        $sql = 'INSERT INTO ' . MOD_TWITCH_INTERFACE_OUTPUT_LOG . '(\'time\', \'errstr\') VALUES(' . time() . ', \'' . $db->sql_escape($errStr) . '\');';
        $db->sql_query($sql);        
    }
    
    public function getLiveChannels($channels = array(), $embedable = false, $hls = false)
    {
        $live = twitch::getStreamsObjects(null, $channels, -1, 0, $embedable, $hls);

        return $live;
    }
    
    public function cleanOutput()
    {
        $sql = 'DELETE * FROM ' . MOD_TWITCH_INTERFACE_OUTPUT_LOG . ';';
        $db->sql_query($sql);
        
        add_log('admin', 'LOG_MOD_TWITCH_OUTPUT_CLEARED', 'output');
    }
    
    public function cleanErrors ()
    {
        $sql = 'DELETE * FROM ' . MOD_TWITCH_INTERFACE_ERROR_LOG . ';';
        $db->sql_query($sql);
        
        add_log('admin', 'LOG_MOD_TWITCH_OUTPUT_CLEARED', 'error');
    }
    
    // Expensive function, will sort through the array of params and add challen to user's follows list
    public function addFollows($params = array())
    {
        
    }
        
    // Our cron task handler
    public function cron($cronTasks = array(), $params = array())
    {
        // Keep track of where we are in the array set
        $counter = 0;
        
        // Switch through our que of tasks to do and apply the target params to the case
        foreach ($cronTasks as $task)
        {
            switch($task)
            {
                // The only task that will be performed on a timer.
                case 'getLive':
                    self::getLiveChannels($params[$counter]);
                    break;
                
                // Added to the que on request
                case 'cleanOutput':
                    self::cleanOutput();
                    break;
                    
                // Added to the que on request
                case 'cleanErrors':
                    self::cleanErrors();
                    break;
                    
                // Likely the most expensive call to be made as this is done on a que.
                case 'addFollows':
                    self::addFollows($params[$counter]);
                    break;
                
                // A catch case, break here for now
                default:
                    break;                
            }
            
            $counter ++;
        }
    }
}
?>