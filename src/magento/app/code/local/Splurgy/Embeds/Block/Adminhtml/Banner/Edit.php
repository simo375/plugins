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
        
        //Dear next person, if I forget to, please delete this.  Keeping it now for reference
        /*if( Mage::registry('embeds_data') && Mage::registry('embeds_data')->getId() ) {
            return Mage::helper('embeds')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('embeds_data')->getTitle()));
        } else {
            return Mage::helper('embeds')->__('Add Item');
        }*/
    }
}
