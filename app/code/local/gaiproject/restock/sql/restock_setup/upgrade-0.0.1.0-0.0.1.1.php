<?php

/** @var $installer Mage_Catalog_Model_Resource_Setup */

$this->startSetup();
 
$this->run("
CREATE TABLE schedule_list (
  `list_id` int(11) unsigned NOT NULL auto_increment,
  `customer` int(11) NOT NULL,
  `billing` text NOT NULL,  
  `preference` text NULL,
  `status` varchar(10) NOT NULL default 'enabled',
  `created_at` datetime NULL,
  `last_run` datetime NULL,
  `last_order` int(11) NULL,
  PRIMARY KEY (`list_id`)
  )
");
$this->run("
CREATE TABLE schedule_list_item (
  `item_id` int(11) unsigned NOT NULL auto_increment,
  `list` int NOT NULL,
  `order` int NOT NULL,
  `product` int NOT NULL,
  `qty` int NOT NULL,
  `buyrequest` text NULL,
  `schedule` varchar(10) NULL,
  `shipping` text NULL,
  `preference` text NULL,
  `status` varchar(10) NOT NULL default 'enabled',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`item_id`)
)
");

$this->endSetup();