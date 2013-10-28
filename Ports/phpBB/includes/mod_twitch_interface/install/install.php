<?php
/**
 * Version 1.0.0
 * 
 * Installation and update file for the phpBB port of Anthony 'IBurn36360' Diaz's
 * twitch_interface.
 */ 
 
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './../../../../';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);
include($phpbb_root_path . 'includes/db/db_tools.' . $phpEx);
include($phpbb_root_path . 'install/install_main.' . $phpEx);
include($phpbb_root_path . 'includes/acp/acp_modules.' . $phpEx);
include($phpbb_root_path . 'includes/acp/auth.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup(array('acp/common', 'mods/info_acp_errors'));

// Version in use
define('MOD_VERSION', '1.0.0');
$version = 'mod_twitch_interface_version';
$mode 	= request_var('mode', '');
$error	= '';

// Check for admin
if (!$auth->acl_get('a_'))
{
	if ($user->data['is_bot'])
	{
		redirect(append_sid("{$phpbb_root_path}index.$phpEx"));
	} else {
		trigger_error('INSTALL_NO_ADMIN');
	}
}

// Set up nneded tools
$db_tools 	= new phpbb_db_tools($db);
$modules 	= new acp_modules();
$auth_admin = new auth_admin();
?>