<?php

########################################################################
# Extension Manager/Repository config file for ext "adminmessage".
#
# Auto generated 31-03-2011 12:50
#
# Manual updates:
# Only the data in the array - everything else is removed by next
# writing. "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Admin Message',
	'description' => 'Enables administrators to send instant messages to users.',
	'category' => 'module',
	'author' => 'Morten Tranberg Hansen',
	'author_email' => 'mth@cs.au.dk',
	'shy' => '',
	'dependencies' => 'aware,jslang',
	'conflicts' => '',
	'priority' => '',
	'module' => 'mod1,cli',
	'state' => 'alpha',
	'internal' => '',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => '',
	'clearCacheOnLoad' => 1,
	'lockType' => '',
	'author_company' => '',
	'version' => '0.0.4',
	'constraints' => array(
		'depends' => array(
			'aware' => '',
			'jslang' => '0.0.4-0.0.0',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:31:{s:9:"ChangeLog";s:4:"d663";s:10:"README.txt";s:4:"ee2d";s:24:"adminmessage_toolbar.css";s:4:"5dc7";s:33:"class.tx_adminmessage_toolbar.php";s:4:"22cc";s:10:"delete.gif";s:4:"7b41";s:12:"ext_icon.gif";s:4:"d8f9";s:17:"ext_localconf.php";s:4:"005e";s:14:"ext_tables.php";s:4:"e280";s:14:"ext_tables.sql";s:4:"fc8d";s:33:"icon_tx_adminmessage_messages.gif";s:4:"475a";s:16:"locallang_db.xml";s:4:"db44";s:21:"locallang_toolbar.xml";s:4:"5e9b";s:8:"mail.gif";s:4:"2498";s:13:"mail_gray.gif";s:4:"e1f7";s:11:"newmail.gif";s:4:"5412";s:16:"newmail_blue.gif";s:4:"d6d2";s:20:"register_toolbar.php";s:4:"88e9";s:7:"tca.php";s:4:"7206";s:26:"tx_adminmessage_toolbar.js";s:4:"2b7e";s:12:"cli/conf.php";s:4:"cb9d";s:14:"cli/cron.phpsh";s:4:"7143";s:19:"doc/wizard_form.dat";s:4:"fed6";s:20:"doc/wizard_form.html";s:4:"1354";s:13:"mod1/ajax.php";s:4:"f2da";s:13:"mod1/conf.php";s:4:"539e";s:14:"mod1/index.php";s:4:"2b1b";s:18:"mod1/locallang.xml";s:4:"1393";s:22:"mod1/locallang_mod.xml";s:4:"92fc";s:22:"mod1/mod_template.html";s:4:"429a";s:19:"mod1/moduleicon.gif";s:4:"cf60";s:23:"mod1/newmessage_form.js";s:4:"16ad";}',
);

?>