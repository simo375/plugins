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
class Splurgy_Embeds_Model_Mysql4_Embeds_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
        {
            //parent::__construct();
            $this->_init('embeds/embeds');
        }
}


