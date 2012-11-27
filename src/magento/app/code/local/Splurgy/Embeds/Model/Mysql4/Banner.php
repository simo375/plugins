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
class Splurgy_Embeds_Model_Mysql4_Banner extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {   
        $this->_init('embeds/banner', 'splurgy_banner_id');
    }
}

