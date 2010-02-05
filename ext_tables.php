<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_adminmessage_messages'] = array (
	'ctrl' => array (
		'title'     => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages',		
		'label'     => 'subject',	
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'default_sortby' => 'ORDER BY crdate',	
		'delete' => 'deleted',	
		'enablecolumns' => array (		
			'disabled' => 'hidden',
		),
		'hideTable' => true,
		//'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		//'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_testext_messages.gif',
	),
);

if (TYPO3_MODE == 'BE') {
	t3lib_extMgm::addModulePath('tools_txadminmessageM1', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');
		
	t3lib_extMgm::addModule('tools', 'txadminmessageM1', 'top', t3lib_extMgm::extPath($_EXTKEY) . 'mod1/');

}
?>