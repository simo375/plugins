<?php
 
$installer = $this;
 
$installer->startSetup();
     
$installer->run(
    "-- DROP TABLE IF EXISTS {$this->getTable('splurgy_banner')};
CREATE TABLE {$this->getTable('splurgy_banner')} (
  `splurgy_banner_id` int(11) unsigned NOT NULL,
  `entityid` int(11) unsigned UNIQUE NOT NULL auto_increment,
  `status` smallint(6) NULL default '0',
  `offerid` int(11) unsigned NULL,
  `bannerimage` varchar(255) NOT NULL,
  PRIMARY KEY (`splurgy_banner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
);
 
$installer->endSetup();
