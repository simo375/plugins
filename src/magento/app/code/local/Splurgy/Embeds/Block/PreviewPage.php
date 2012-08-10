<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Splurgy_Embeds_Block_PreviewPage extends Mage_Adminhtml_Block_System_Config_Form_Field {
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('splurgy/preview.phtml');
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }
}
?>
