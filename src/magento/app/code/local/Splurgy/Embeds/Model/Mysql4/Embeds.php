<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OfferID
 *
 * @author splurgy
 */
class Splurgy_Embeds_Model_Mysql4_Embeds extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('embeds/embeds', 'embeds_id');
    }
}

