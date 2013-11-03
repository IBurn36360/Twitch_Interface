<?php
if (!defined('IN_PHPBB') || !defined('IN_INSTALL'))
{
    exit;
}

// Storage

//CREATE  TABLE `test`.`mod_twitch_interface_error_log` (
//`time` INT NOT NULL ,
//`errno` INT NOT NULL ,
//`errstr` LONGBLOB NOT NULL ,
//PRIMARY KEY (`time`) );

//CREATE  TABLE `test`.`mod_twitch_interface_output_log` (
//`time` INT NOT NULL ,
//`errstr` LONGBLOB NOT NULL ,
//PRIMARY KEY (`time`) );

class twitchInterfaceInstaller
{
	function add_config_install($config_data)
	{
		global $config, $db;
		
		foreach ($config_data as $config_name => $config_array)
		{
			set_config($config_name, $config_array[0], $config_array[1]);
			add_log('admin', 'LOG_INSTALL_CONFIG_ADD', $config_name);
		}
		return true;
	}
    
 	function delete_config($config_name)
	{
		global $config, $db;
		
		if (isset($config[$config_name]))
		{
			$sql = 'DELETE FROM ' . CONFIG_TABLE . ' WHERE config_name = \'' . $db->sql_escape($config_name) . '\'';
			$db->sql_query($sql);
			
			add_log('admin', 'LOG_INSTALL_CONFIG_DEL', $config_name);
			
			unset($config[$config_name]);
			return true;
		}
		return false;
	}
    
	function delete_table($tables)
	{
		global $db, $db_tools;
		
		foreach ($tables as $table_name)
		{
			if ($db_tools->sql_table_exists($table_name))
			{
				add_log('admin', 'LOG_INSTALL_TABLE_DEL', $table_name);
				$db_tools->sql_table_drop($table_name);
			}
		}
	}
    
    function create_table($table, $collumns = array())
    {
        global $db, $db_tools;
        
        if (!$db_tools->sql_table_exists($table))
        {
            add_log('admin', 'LOG_INSTALL_TABLE_ADD', $table);
            $db_tools->sql_create_table($table, $collumns);
        }
        
    }
}
?>