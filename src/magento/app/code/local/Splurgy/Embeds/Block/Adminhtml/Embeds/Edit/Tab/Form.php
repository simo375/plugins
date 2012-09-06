<?php
 
class Splurgy_Embeds_Block_Adminhtml_Embeds_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('embeds_form', array('legend'=>Mage::helper('embeds')->__('Offer information')));
        
        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('embeds')->__('Status'),
            'name'      => 'status',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('embeds')->__('Active'),
                ),
 
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('embeds')->__('Inactive'),
                ),
            ),
        ));
        
        $fieldset->addField('offerid', 'text', array(
            'name'      => 'offerid',
            'label'     => Mage::helper('embeds')->__('OfferID'),
            'title'     => Mage::helper('embeds')->__('OfferID'),
            'required'  => true,
        ));
        
       
        if ( Mage::getSingleton('adminhtml/session')->getEmbedsData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getEmbedsData());
            Mage::getSingleton('adminhtml/session')->setEmbedsData(null);
        } elseif ( Mage::registry('embeds_data') ) {
            $form->setValues(Mage::registry('embeds_data')->getData());
        }
        return parent::_prepareForm();
    }
}