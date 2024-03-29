<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2009 Morten Tranberg Hansen <mth@cs.au.dk>
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
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/
/**
 * [CLASS/FUNCTION INDEX of SCRIPT]
 *
 * Hint: use extdeveval to insert/update function index above.
 */


$LANG->includeLLFile('EXT:adminmessage/mod1/locallang.xml');
require_once(PATH_t3lib . 'class.t3lib_scbase.php');
$BE_USER->modAccess($MCONF,1);	// This checks permissions and exits if the users has no permission for entry.
	// DEFAULT initialization of a module [END]



/**
 * Module 'Messages' for the 'adminmessage' extension.
 *
 * @author	Morten Tranberg Hansen <mth@cs.au.dk>
 * @package	TYPO3
 * @subpackage	tx_adminmessage
 */
class tx_adminmessage_module1 extends t3lib_SCbase {

				var $pageinfo;

				/**
				 * Initializes the Module
				 * @return	void
				 */
				function init()	{

					parent::init();

					/*
					if (t3lib_div::_GP('clear_all_cache'))	{
						$this->include_once[] = PATH_t3lib.'class.t3lib_tcemain.php';
					}
					*/
				}

				/**
				 * Adds items to the ->MOD_MENU array. Used for the function menu selector.
				 *
				 * @return	void
				 */
				function menuConfig()	{

					$this->MOD_MENU = Array (
																	 'function' => Array (
																												'1' => $GLOBALS['LANG']->getLL('function1'),
																												'2' => $GLOBALS['LANG']->getLL('function2'),
																												//'3' => $GLOBALS['LANG']->getLL('function3'),
																												)
																	 );
					parent::menuConfig();
				}

				/**
				 * Main function of the module. Write the content to $this->content
				 * If you chose "web" as main module, you will need to consider the $this->id parameter which will contain the uid-number of the page clicked in the page tree
				 *
				 * @return	[type]		...
				 */
				function main()	{

						// initialize doc
					$this->doc = t3lib_div::makeInstance('template');
					$this->doc->setModuleTemplate(t3lib_extMgm::extPath('adminmessage') . 'mod1/mod_template.html');
					$this->doc->backPath = $GLOBALS['BACK_PATH'];
					$this->doc->getPageRenderer()->loadExtJS();

					$docHeaderButtons = $this->getButtons();

					$function = (string)$this->MOD_SETTINGS['function'];

					if (true || $function!=2 || ($function==2 && $GLOBALS['BE_USER']->user['admin'])) {
						
	
						// Draw the form
						//$this->doc->form = '<form action="" method="post" enctype="multipart/form-data">';
						
						// JavaScript
						$this->doc->JScode = '
							<script language="javascript" type="text/javascript">
								script_ended = 0;
								function jumpToUrl(URL)	{
									document.location = URL;
								}
							</script>
						';
						$this->doc->postCode='
							<script language="javascript" type="text/javascript">
								script_ended = 1;
								if (top.fsMod) top.fsMod.recentIds["web"] = 0;
							</script>
						';
						// Render content:
						$this->moduleContent();
					} else {
						// If no access or if ID == zero
						$docHeaderButtons['save'] = '';
						$this->content.=$this->doc->spacer(10);
					}
					
					// compile document
					
					if(false && $GLOBALS['BE_USER']->user['admin']) {
						// function menu
						$markers['FUNC_MENU'] = t3lib_BEfunc::getFuncMenu(0, 'SET[function]', $this->MOD_SETTINGS['function'], $this->MOD_MENU['function']);
					} else {
						// no function menu
						$markers['FUNC_MENU'] = '';
					}
					
					$markers['CONTENT'] = $this->content;
					
					// Build the <body> for the module
					$this->content = $this->doc->startPage($GLOBALS['LANG']->getLL('title'));
					$this->content.= $this->doc->moduleBody($this->pageinfo, $docHeaderButtons, $markers);
					$this->content.= $this->doc->endPage();
					$this->content = $this->doc->insertStylesAndJS($this->content);
						
				}

				/**
				 * Prints out the module HTML
				 *
				 * @return	void
				 */
				function printContent()	{

					//$this->content.=$this->doc->endPage();
					echo $this->content;
				}

				/**
				 * Generates the module content
				 *
				 * @return	void
				 */
				function moduleContent()	{

					switch((string)$this->MOD_SETTINGS['function'])	{
						case 1:
							$content=$this->newMessageContent();
							$this->content.=$this->doc->section($GLOBALS['LANG']->getLL('function1'),$content,0,1);														
						break;
						case 2:
							$content='<div align=center><strong>Menu item #2...</strong></div>';
							$this->content.=$this->doc->section($GLOBALS['LANG']->getLL('function2'),$content,0,1);
						break;
						case 3:
							$content='<div align=center><strong>Menu item #3...</strong></div>';
							$this->content.=$this->doc->section($GLOBALS['LANG']->getLL('function3'),$content,0,1);
						break;
					}
				}
				

				/**
				 * Create the panel of buttons for submitting the form or otherwise perform operations.
				 *
				 * @return	array	all available buttons as an assoc. array
				 */
				protected function getButtons()	{

					$buttons = array(
						'csh' => '',
						'shortcut' => '',
						'save' => ''
					);
						// CSH
					$buttons['csh'] = t3lib_BEfunc::cshItem('_MOD_web_func', '', $GLOBALS['BACK_PATH']);

						// SAVE button
					//$buttons['save'] = '<input type="image" class="c-inputButton" name="submit" value="Update"' . t3lib_iconWorks::skinImg($GLOBALS['BACK_PATH'], 'gfx/savedok.gif', '') . ' title="' . $GLOBALS['LANG']->sL('LLL:EXT:lang/locallang_core.php:rm.saveDoc', 1) . '" />';


						// Shortcut
					if ($GLOBALS['BE_USER']->mayMakeShortcut())	{
						$buttons['shortcut'] = $this->doc->makeShortcutIcon('', 'function', $this->MCONF['name']);
					}

					return $buttons;
				}

				protected function newMessageContent() {

					tx_jslang::addLL($this->doc, 'EXT:adminmessage/mod1/locallang.xml','adminmessage');
					$this->doc->loadJavascriptLib(t3lib_extMgm::extRelPath('adminmessage').'mod1/newmessage_form.js');
					$this->doc->getPageRenderer()->enableExtJsDebug();

					$result .= '<div id="newmessage"></div>';					

					return $result;
				}
				
		}



if (defined('TYPO3_MODE') && isset($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/adminmessage/mod1/index.php']))	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/adminmessage/mod1/index.php']);
}




// Make instance:
$SOBE = t3lib_div::makeInstance('tx_adminmessage_module1');
$SOBE->init();

// Include files?
foreach($SOBE->include_once as $INC_FILE)	include_once($INC_FILE);

$SOBE->main();
$SOBE->printContent();

?>