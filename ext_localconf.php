<?php
if (!defined ('TYPO3_MODE')) {
 	die ('Access denied.');
}

$TYPO3_CONF_VARS['BE']['AJAX']['tx_adminmessage_mod1::sendMessage'] = 'EXT:adminmessage/mod1/ajax.php:tx_adminmessage_module1_ajax->sendMessage';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_adminmessage_mod1::getGroups'] = 'EXT:adminmessage/mod1/ajax.php:tx_adminmessage_module1_ajax->getGroups';
$TYPO3_CONF_VARS['BE']['AJAX']['tx_adminmessage_mod1::getUsers'] = 'EXT:adminmessage/mod1/ajax.php:tx_adminmessage_module1_ajax->getUsers';

$TYPO3_CONF_VARS['typo3/backend.php']['additionalBackendItems'][] = t3lib_extMgm::extPath('adminmessage').'register_toolbar.php';

$TYPO3_CONF_VARS['BE']['AJAX']['tx_adminmessage_toolbar_ajax::renderMenu'] = 'EXT:adminmessage/class.tx_adminmessage_toolbar_ajax.php:tx_adminmessage_toolbar_ajax->renderMenu';

$TYPO3_CONF_VARS['EXTCONF']['aware']['listeners']['hide#adminmessage'][] = 'EXT:adminmessage/class.tx_adminmessage_toolbar.php:tx_adminmessage_toolbar->hideMessage';

$TYPO3_CONF_VARS['EXTCONF']['aware']['listeners']['seen#adminmessage'][] = 'EXT:adminmessage/class.tx_adminmessage_toolbar.php:tx_adminmessage_toolbar->seenMessages';

$TYPO3_CONF_VARS['EXTCONF']['aware']['newchannel'][] = 'EXT:adminmessage/class.tx_adminmessage_toolbar.php:tx_adminmessage_toolbar->newChannel';

?>
