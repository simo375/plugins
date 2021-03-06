<?php
 
class Splurgy_Embeds_Block_Adminhtml_Embeds_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
 
    public function __construct()
    {
        parent::__construct();
        $this->setId('embeds_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('embeds')->__('Information'));
    }
 
    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('embeds')->__('Offer Information'),
            'title'     => Mage::helper('embeds')->__('Offer Information'),
            'content'   => $this->getLayout()->createBlock('embeds/adminhtml_embeds_edit_tab_forms')->toHtml(),
        ));
       
        return parent::_beforeToHtml();
    }
}
