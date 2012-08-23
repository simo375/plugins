<?php
 
class Splurgy_Embeds_Block_Adminhtml_Embeds_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
               
        $this->_objectId = 'id';
        $this->_blockGroup = 'embeds';
        $this->_controller = 'adminhtml_embeds';
 
        $this->_updateButton('save', 'label', Mage::helper('embeds')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('embeds')->__('Delete Item'));
    }
 
    public function getHeaderText()
    {
        if( Mage::registry('embeds_data') && Mage::registry('embeds_data')->getId() ) {
            return Mage::helper('embeds')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('embeds_data')->getTitle()));
        } else {
            return Mage::helper('embeds')->__('Add Item');
        }
    }
}
