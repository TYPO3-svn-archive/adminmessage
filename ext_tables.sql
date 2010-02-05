#
# Table structure for table 'tx_adminmessage_messages'
#
CREATE TABLE tx_adminmessage_messages (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	be_user text,
	importance int(11) DEFAULT '0' NOT NULL,
	subject tinytext,
	message text,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	seen tinyint(4) DEFAULT '0' NOT NULL,
	started tinyint(4) DEFAULT '0' NOT NULL,
	ended tinyint(4) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);