<?php

if (!defined('TYPO3_MODE')) 	die ('Access denied.');

if (TYPO3_MODE == 'BE') {

	t3lib_div::requireOnce(t3lib_extMgm::extPath('adminmessage').'class.tx_adminmessage_toolbar.php');
	$TYPO3backend->addToolbarItem('adminmessage', 'tx_adminmessage_toolbar');
}

?>