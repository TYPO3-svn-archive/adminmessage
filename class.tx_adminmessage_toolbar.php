<?php 
/***************************************************************
*  Copyright notice
*
*  (c) 2010 Morten Tranberg Hansen (mth at cs dot au dot dk)
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*  A copy is found in the textfile GPL.txt and important notices to the license
*  from the author is found in LICENSE.txt distributed with these scripts.
*
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * The 'adminmessage' toolbar that is hooked into the backend.
 *
 * @author Morten Tranberg Hansen <mth at cs dot au dot dk>
 * @date   January 3 2010
 */

t3lib_div::requireOnce(PATH_typo3.'interfaces/interface.backend_toolbaritem.php');

// load the language file
$GLOBALS['LANG']->includeLLFile('EXT:adminmessage/locallang_toolbar.xml');

class tx_adminmessage_toolbar implements backend_toolbarItem {

	var $backendReference;
	var $newMail;

	/**
	 * Constructor that receives a back reference to the backend
	 *
	 * @param	TYPO3backend	TYPO3 backend object reference
	 */
	public function __construct(TYPO3backend &$backendReference = null) {
		
		$this->backendReference = $backendReference;
		$this->newMail = FALSE;

	}

	/**
	 * Checks whether the user has access to this toolbar item
	 *
	 * @return  boolean  true if user has access, false if not
	 */
	public function checkAccess() {

		return true;
	}

	/**
	 * Renders the toolbar item
	 *
	 * @return	string	the toolbar item rendered as HTML string
	 */
	public function render() {
		
		$this->addCss();
		$this->addJs();

		$title = $GLOBALS['LANG']->getLL('title');

		$result = '';

		$result .= '<a href="#" class="toolbar-item">';
		$result .= '<img' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], t3lib_extMgm::extRelPath('adminmessage').($this->newMail?'newmail.gif':'mail_gray.gif'), 'width="16" height="16"') . '  alt="' . $title . '" title="' . $title . '" id="tx-adminmessage-toolbar-icon"/>';
		$result .= '</a>';

		$result .= '<ul class="toolbar-item-menu" style="display:none;"></ul>';

		return $result;

	}

	private function addCss() {
		$this->backendReference->addCssFile('adminmessage', t3lib_extMgm::extRelPath('adminmessage') . 'adminmessage_toolbar.css');
	}
	
	private function addJs() {

		$this->backendReference->addJavascriptFile(t3lib_extMgm::extRelPath('adminmessage') . 'tx_adminmessage_toolbar.js');

		tx_jslang::addLL($GLOBALS['TBE_TEMPLATE'], t3lib_extMgm::extPath('adminmessage') . 'locallang_toolbar.xml', 'adminmessage_toolbar');

		$messages = array();
		$res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('*', 'tx_adminmessage_messages', 'be_user=\''.$GLOBALS['BE_USER']->user['uid'].'\' AND hidden=0 AND (endtime=0 OR endtime>'.$GLOBALS['EXEC_TIME'].')', '', 'crdate ASC');
		while($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
			$messages[] = $row;
			if (!$row['seen']) {
				$this->newMail = TRUE;
			}
		}

		$this->backendReference->addJavascript('TYPO3.tx_adminmessage_toolbar_messages = '.json_encode($messages).';');
	}


	/**
	 * Returns additional attributes for the list item in the toolbar
	 *
	 * @return	string		list item HTML attibutes
	 */
	public function getAdditionalAttributes() {
		return ' id="tx-adminmessage-toolbar-menu"';
	}
		

	/**
	 * Aware 'hide:adminmessage' listener.
	 *
	 * @param array the event
	 */
	public function hideMessage(array &$event) {

		$uid = $event['data']['uid'];
		$message = t3lib_BEfunc::getRecord('tx_adminmessage_messages', $uid);
		
		if ($GLOBALS['BE_USER']->user['uid']==$message['be_user']) {
			$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_adminmessage_messages', 'uid='.$uid, array('hidden' => 1));
		}

	}

	/**
	 * Aware 'seen:adminmessage' listener.
	 *
	 * @param array the event
	 */
	public function seenMessages(array &$event) {

		$GLOBALS['TYPO3_DB']->exec_UPDATEquery('tx_adminmessage_messages', 'uid<=' . $event['data']['uid'] . ' AND be_user=' . $GLOBALS['BE_USER']->user['uid'], array('seen'=>1));
		
	}

	
	/**
	 * Aware new channel hook that gets called whenever a new channel is created.
	 * Is used to set the default lifetime of adminmessag hide and seen channels.
	 * 
	 * @param	string the new channel
	 * @return void
	 * @access public
	 */	

	public function newChannel($channel) {

		if(strcmp($channel,'seen#adminmessage')==0 || strcmp($channel,'hide#adminmessage')==0) {
			tx_aware::setChannelLifetime($channel, 30);
		}

	}

}
