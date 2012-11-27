<?php
 
class Splurgy_Embeds_Block_Adminhtml_Banner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
        $this->_objectId = 'id';
        $this->_blockGroup = 'embeds';
        $this->_controller = 'adminhtml_banner';
 
        $this->_updateButton('save', 'label', Mage::helper('embeds')->__('Save Offer'));
        $this->_removeButton('delete');
    }
 
    public function getHeaderText()
    {
        return Mage::helper('embeds')->__('Edit Offer');
    }
}
