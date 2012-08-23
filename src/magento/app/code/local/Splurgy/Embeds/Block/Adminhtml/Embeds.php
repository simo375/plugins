<?php
 
class Splurgy_Embeds_Block_Adminhtml_Embeds extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_embeds';
        $this->_blockGroup = 'embeds';
        $this->_headerText = Mage::helper('embeds')->__('Item Manager');
        $this->_addButtonLabel = Mage::helper('embeds')->__('Add Item');
        parent::__construct();
    }
}
