<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA['tx_adminmessage_messages'] = array (
	'ctrl' => $TCA['tx_adminmessage_messages']['ctrl'],
	'interface' => array (
		'showRecordFieldList' => 'hidden,be_user,be_group,importance,subject,message,start_date,start_time,end_date,end_time'
	),
	'feInterface' => $TCA['tx_adminmessage_messages']['feInterface'],
	'columns' => array (
		'hidden' => array (		
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'be_user' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.be_user',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'be_users',	
				'foreign_table_where' => 'ORDER BY be_users.uid',	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
		'be_group' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.be_group',		
			'config' => array (
				'type' => 'select',	
				'foreign_table' => 'be_groups',	
				'foreign_table_where' => 'ORDER BY be_groups.uid',	
				'size' => 5,	
				'minitems' => 0,
				'maxitems' => 100,
			)
		),
		'importance' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.importance',		
			'config' => array (
				'type' => 'select',
				'items' => array (
					array('LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.importance.I.0', '0', t3lib_extMgm::extRelPath('adminmessage').'selicon_tx_adminmessage_messages_importance_0.gif'),
					array('LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.importance.I.1', '1', t3lib_extMgm::extRelPath('adminmessage').'selicon_tx_adminmessage_messages_importance_1.gif'),
				),
				'size' => 1,	
				'maxitems' => 1,
			)
		),
		'subject' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.subject',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'eval' => 'required',
			)
		),
		'message' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.message',		
			'config' => array (
				'type' => 'text',
				'cols' => '30',
				'rows' => '5',
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly'       => 1,
						'type'          => 'script',
						'title'         => 'Full screen Rich Text Editing|Formatteret redigering i hele vinduet',
						'icon'          => 'wizard_rte2.gif',
						'script'        => 'wizard_rte.php',
					),
				),
			)
		),
		'start_date' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.start_date',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'checkbox' => '0',	
				'eval' => 'date,required',
			)
		),
		'start_time' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.start_time',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'checkbox' => '0',	
				'eval' => 'time,required',
			)
		),
		'end_date' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.end_date',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'checkbox' => '0',	
				'eval' => 'date',
			)
		),
		'end_time' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.end_time',		
			'config' => array (
				'type' => 'input',	
				'size' => '30',	
				'checkbox' => '0',	
				'eval' => 'time',
			)
		),
		'editlock' => array (		
			'exclude' => 0,		
			'label' => 'LLL:EXT:test_ext/locallang_db.xml:tx_adminmessage_messages.editlock',		
			'config' => array (
				'type' => 'check',
				'default' => 1,
			)
		),
	),
	'types' => array (
		'0' => array('showitem' => 'hidden;;1;;1-1-1, editlock, importance, subject, message;;;richtext[cut|copy|paste|formatblock|bold|italic|underline|left|center|right|orderedlist|unorderedlist|link|chMode]:rte_transform[mode=ts_css|imgpath=uploads/tx_adminmessage/rte/], --div--;LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.tabs.target,be_user, be_group, --div--;LLL:EXT:adminmessage/locallang_db.xml:tx_adminmessage_messages.tabs.timeframe, start_date, start_time, end_date, end_time')
	),
	'palettes' => array (
		'1' => array('showitem' => '')
	)
);
?>