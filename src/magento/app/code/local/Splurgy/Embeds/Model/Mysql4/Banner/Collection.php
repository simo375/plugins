<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Collection
 *
 * @author splurgy
 */
class Splurgy_Embeds_Model_Mysql4_Banner_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
            //parent::__construct();
            $this->_init('embeds/banner');
    }
    
    public function addAttributeToSelect($field)
    {
        Mage_Core_Model_Resource_Db_Collection_Abstract::addAttributeToSelect($field);
    }
}


