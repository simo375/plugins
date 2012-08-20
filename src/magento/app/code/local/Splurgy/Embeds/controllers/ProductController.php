<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductController
 *
 * @author splurgy
 */
class Splurgy_Embeds_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    protected $splurgyOfferId;
    
    public function _construct() {
        parent::_construct();
        $this->splurgyOfferId = Mage::getModel('Splurgy_Embeds_Model_Observer');
    }
    
    public function saveAction() {
        $this->splurgyOfferId->saveProductTabData();
    }
}

?>
