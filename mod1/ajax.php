<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Morten Tranberg Hansen (mth at cs dot au dot dk)
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
 * AJAX functions for 'adminmessage' module1.
 *
 * @author	Morten Tranberg Hansen <mth@cs.au.dk>
 * @package	TYPO3
 * @subpackage	tx_adminmessage
 */
class tx_adminmessage_module1_ajax {

	public function sendMessage(array $params = array(), TYPO3AJAX &$ajaxObj) {

		$table = 'tx_adminmessage_messages';

		$subject = t3lib_div::_GP('subject');//$TYPO3_DB->quoteStr(t3lib_div::_GP('subject'), $table);
		$message = t3lib_div::_GP('message');//$TYPO3_DB->quoteStr(t3lib_div::_GP('message'), $table);
		$user = intval(t3lib_div::_GP('user'));
		$group = intval(t3lib_div::_GP('group'));
		$start = intval(t3lib_div::_GP('start')/1000);
		$end = intval(t3lib_div::_GP('end')/1000);

		if (!empty($subject) && !empty($start)) {

			$all_users = t3lib_BEfunc::getUserNames('uid,username,usergroup,usergroup_cached_list','AND username NOT LIKE \'%_CLI_%\'');			

			$users = array();

			if ($user) {
				$users[] = $user;
			} elseif ($group) {
				
				$all_groups = t3lib_BEfunc::getGroupNames('title,uid,subgroup');

				foreach($all_users as $u) {
					
					if ($u['usergroup']) {

						$fetched = $this->fetchGroups($u['usergroup'], $all_groups);
						if (t3lib_div::inArray($fetched, $group)) {
							$users[] = $u['uid'];
						}

					}
				}
				
			} else {
				foreach($all_users as $u) {
					$users[] = $u['uid'];
				}
			}
			
			foreach($users as $uid) {
				$values = array('tstamp'=>$GLOBALS['EXEC_TIME'], 'crdate'=>$GLOBALS['EXEC_TIME'], 'cruser_id'=>$GLOBALS['BE_USER']->user['uid'], 'subject'=>$subject, 'message'=>$message, 'be_user'=>$uid, 'starttime'=>$start, 'endtime'=>$end);

				if ($start<=$GLOBALS['EXEC_TIME']) {
					$values['started'] = 1;
				}

				$GLOBALS['TYPO3_DB']->exec_INSERTquery($table, $values);	
				$values['uid'] = $GLOBALS['TYPO3_DB']->sql_insert_id();
				
				if ($start<=$GLOBALS['EXEC_TIME']) {
					tx_aware::addEvent('new#adminmessage:'.$all_users[$uid]['username'], $values, true);
				}

			}

			//tx_aware::addEvent('new#adminmessage', array('subject'=>$subject, 'message'=>$message), true);

			$ajaxObj->addContent('success', true);
		}

		$ajaxObj->setContentFormat('json');

	}

	/*
	 * AJAX function polled adminmessage form to get all be_groups.
	 *
	 */
	public function getGroups(array $params = array(), TYPO3AJAX &$ajaxObj) {

		$ajaxObj->addContent('groups',array_values(t3lib_BEfunc::getGroupNames('uid,title')));
		$ajaxObj->setContentFormat('json');

	}

	/*
	 * AJAX function polled adminmessage form to get all be_users.
	 *
	 */
	public function getUsers(array $params = array(), TYPO3AJAX &$ajaxObj) {

		$ajaxObj->addContent('users',array_values(t3lib_BEfunc::getUserNames('uid,username','AND username NOT LIKE \'%_CLI_%\'')));
		$ajaxObj->setContentFormat('json');
		
	}

	/*
	 * Recursive function to fetch all groups that a user belongs to.
	 */
	private function fetchGroups($grList, $all_groups, $fetched=array()) {

		$grArray = t3lib_div::intExplode(',',$GLOBALS['TYPO3_DB']->cleanIntList($grList));

		foreach($grArray as $grUid) {
			
			if (empty($fetched) || !t3lib_div::inArray($fetched, $grUid)) {
				$fetched[] = $grUid;				

				if ($all_groups[$grUid]['subgroup']) {
					$fetched = array_merge($fetched, $this->fetchGroups($all_groups[$grUid]['subgroup'], $all_groups, $fetched));
				}
				
			}
			
		}

		return array_unique($fetched);
	}

}

if (defined('TYPO3_MODE') && isset($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/adminmessage/mod1/ajax.php'])) {
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/adminmessage/mod1/ajax.php']);
}

?>