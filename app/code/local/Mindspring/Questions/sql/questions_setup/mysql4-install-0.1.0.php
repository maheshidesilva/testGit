<?php
$installer = $this;
$installer->startSetup();
$installer->run("
	DROP TABLE IF EXISTS {$this->getTable('questions')};
	CREATE TABLE {$this->getTable('questions')} (
	`questions_id` int(11) unsigned NOT NULL auto_increment,
	`questions_name` varchar(255) NOT NULL default '',
	`questions_description` text NOT NULL default '',
	`questions_location` varchar(255) NOT NULL default '',
	`status` smallint(6) NOT NULL default '0',
	`created_time` datetime NULL,
	`update_time` datetime NULL,
	PRIMARY KEY (`questions_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
$installer->endSetup();