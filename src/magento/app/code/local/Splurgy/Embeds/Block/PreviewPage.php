<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Splurgy_Embeds_Block_PreviewPage extends Mage_Adminhtml_Block_System_Config_Form_Field {
    protected $splurgyToken;
    
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('splurgy/preview.phtml');
        $this->splurgyToken  = Mage::getModel('Splurgy_Embeds_Model_Token');
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }
    
    
}
?>
