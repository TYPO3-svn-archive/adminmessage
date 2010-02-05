<?php

########################################################################
# Extension Manager/Repository config file for ext "adminmessage".
#
# Auto generated 03-01-2010 12:50
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
	'dependencies' => 'aware',
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
	'version' => '0.0.3',
	'constraints' => array(
		'depends' => array(
			'aware' => '',
			'jslang' => '',
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'suggests' => array(
	),
	'_md5_values_when_last_written' => 'a:17:{s:9:"ChangeLog";s:4:"8a3b";s:10:"README.txt";s:4:"ee2d";s:12:"ext_icon.gif";s:4:"1bdc";s:17:"ext_localconf.php";s:4:"a4ce";s:14:"ext_tables.php";s:4:"e80a";s:22:"register_js_client.php";s:4:"e226";s:25:"tx_adminmessage_client.js";s:4:"8497";s:19:"doc/wizard_form.dat";s:4:"fed6";s:20:"doc/wizard_form.html";s:4:"1354";s:13:"mod1/ajax.php";s:4:"5e46";s:13:"mod1/conf.php";s:4:"8484";s:14:"mod1/index.php";s:4:"64b5";s:18:"mod1/locallang.xml";s:4:"97a2";s:22:"mod1/locallang_mod.xml";s:4:"62e5";s:22:"mod1/mod_template.html";s:4:"429a";s:19:"mod1/moduleicon.gif";s:4:"8074";s:23:"mod1/newmessage_form.js";s:4:"f3e1";}',
);

?>