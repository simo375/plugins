<?php
 
class Splurgy_Embeds_Block_Adminhtml_Banner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                  'enctype' => 'multipart/form-data'
            )
        );
        $fieldset = $form->addFieldset('base_fieldset',	array('legend'=>Mage::helper('adminhtml')->__('Account Information')));
        
        
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
            'value' => Mage::registry('embeds_data')->offerid,

        ));


          $fieldset->addField('bannerimage', 'text', array(
          'label'     => Mage::helper('embeds')->__('File URL'),
          'required'  => true,
          'name'      => 'bannerimage',
        ));


        $form->setUseContainer(true);
        $this->setForm($form);
        
        return parent::_prepareForm();
    }

}
