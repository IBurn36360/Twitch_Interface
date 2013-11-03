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
$user->setup(array('acp/common', 'mods/info_mod_twitch_interface'));

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

// Set up needed tools
include($phpbb_root_path . 'includes/mod_twitch_interface/install/install_common.php');
$db_tools 	= new phpbb_db_tools($db);
$install    = new twitchInterfaceInstaller();
$modules 	= new acp_modules();
$auth_admin = new auth_admin();

// Set up our redirects
$url_install = append_sid("{$phpbb_root_path}mod_twitch_interface_install/install.$phpEx");
$uninstall   = append_sid("{$phpbb_root_path}mod_twitch_interface_install/install.$phpEx", 'mode=del');
$update  	 = append_sid("{$phpbb_root_path}mod_twitch_interface_install/install.$phpEx", 'mode=update');
$instal_mod  = append_sid("{$phpbb_root_path}mod_twitch_interface_install/install.$phpEx", 'mode=install');

// Check if current version already installed
if (isset($config[$version]))
{
	if ($config[$version] == MOD_VERSION)
	{
		define('CUR_VERSION', 1);
		if (!$mode)
		{
			trigger_error(sprintf($user->lang['INSTALL_CHECK_FINISH_TITLE'], NAME_MOD, MOD_VERSION). '<br /><br />' .sprintf($user->lang['UNINSTALL_ERRORS_MOD'], NAME_MOD, MOD_VERSION, $uninstall). '<br /><br />' .$user->lang['INSTALL_FINISH_MESSAGE']);
		}
	}
} else {
	define('CUR_VERSION', 0);
	if (!$mode)
	{
		trigger_error(sprintf($user->lang['INSTALL_CHECK_NO_TITLE'], NAME_MOD). '<br /><br />' .sprintf($user->lang['INSTALL_CHECK_INSTALL_TITLE'], $instal_mod));
	}
}

// What are we trying to do?
switch($mode)
{
    // We are deleting all of the structure in the DB and the permission system for the mod
    case 'del':
    
    break;
    
    // Update the mod to a new version
    case 'update':
        // What version was reported in the DB
        switch(($config[$version]))
        {
            case '1.0.0':
            
            break;
            
            // Somehow the DB reports a version we don't recognize, toss an error to the admin attempting the update
            default:
                trigger_error();
            break;
        }
    break;
    
    // Install the mod and put in all of the stucture for it    
    case 'install':
    
    break;
    
    // Catch, redirect to the main install page
    default:
    
    break;   
}
?>