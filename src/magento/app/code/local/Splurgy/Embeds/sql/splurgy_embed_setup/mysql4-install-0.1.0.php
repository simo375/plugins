<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("
 
-- DROP TABLE IF EXISTS {$this->getTable('splurgy_embed')};
CREATE TABLE {$this->getTable('splurgy_embed')} (
  `splurgy_embed_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `entityid` int(11) unsigned UNIQUE NULL,
  `status` smallint(6) NOT NULL default '0',
  `offerid` int(11) unsigned NULL,
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`splurgy_embed_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO splurgy_embed (entityid)
SELECT catalog_product_entity.entity_id 
FROM catalog_product_entity;

UPDATE splurgy_embed, catalog_product_flat_1
SET splurgy_embed.title = catalog_product_flat_1.name
WHERE splurgy_embed.entityid = catalog_product_flat_1.entity_id;
 
    ");
 
$installer->endSetup();
