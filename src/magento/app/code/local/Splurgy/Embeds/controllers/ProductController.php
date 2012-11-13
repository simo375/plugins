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
    protected $_splurgyOfferId;
    
    public function _construct() 
    {
        parent::_construct();
        $this->_splurgyOfferId = Mage::getModel('Splurgy_Embeds_Model_Observer');
    }
    
    public function saveAction() 
    {
        $this->_splurgyOfferId->saveProductTabData();
    }
}