<?php
 
class Splurgy_Embeds_Block_Adminhtml_Banner_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    
    protected function _prepareForm()
    {
        
        //Make connection to database
        $databaseconnection = Mage::GetSingleton('core/resource');
        //Let it be read
        $readdata = $databaseconnection->getConnection('core_read');
        
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method' => 'post',
                  'enctype' => 'multipart/form-data'
            )
        );
        $fieldset = $form
        ->addFieldset('base_fieldset',	array('legend'=>Mage::helper('adminhtml')->__('Coupon Information')));
        
        //Get status from database
        $query = 'SELECT status FROM ' . $databaseconnection->getTableName ('splurgy_banner') . ' WHERE entityid = 1';
        
        $fieldset->addField(
            'status', 'select', 
            array(
            'label'     => Mage::helper('embeds')->__('Status'),
            'name'      => 'status',
            //Find the status setting in the database and autofill
            'value'     => $readdata->fetchOne($query),
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
        )
        );
        
        //Get offerid from database
        $query = 'SELECT offerid FROM ' . $databaseconnection->getTableName ('splurgy_banner') . ' WHERE entityid = 1';

        
        $fieldset->addField(
            'offerid', 'text', 
            array(
            'name'      => 'offerid',
            'label'     => Mage::helper('embeds')->__('OfferID'),
            'title'     => Mage::helper('embeds')->__('OfferID'),
            'required'  => true,
            //Find the offerid setting in the database and autofill
            'value' => $readdata->fetchOne($query),

        )
        );

        //Get bannerimage from database
        $query = 'SELECT bannerimage FROM ' 
        . $databaseconnection->getTableName('splurgy_banner') 
        . ' WHERE entityid = 1';

          $fieldset->addField(
              'bannerimage', 'text', 
              array(
              'label'     => Mage::helper('embeds')->__('File URL'),
              'required'  => true,
              'name'      => 'bannerimage',
              //Find the bannerimage setting in the database and autofill
              'value'     => $readdata->fetchOne($query),
          )
          );


        $form->setUseContainer(true);
        $this->setForm($form);
        
        return parent::_prepareForm();
    }

}
