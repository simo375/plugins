<?php

class Splurgy_Embeds_Block_Deletetoken extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('system/config/system/storage/media/synchronize.phtml');
    }


    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }

    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'id'        => 'token_button',
                'label'     => $this->helper('adminhtml')->__('Delete Token'),
            ));

        return $button->toHtml();
    }



}