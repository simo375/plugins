<?php
class Splurgy_Embeds_ConfigController extends Mage_Adminhtml_Controller_Action {        

    public function deleteAction()
    {
        $tokenModel = Mage::getModel('Splurgy_Embeds_Model_Token');
        $tokenModel->delete();
        Mage::getSingleton('core/session')->addSuccess('Successfully Deleted Token!');
        $this->_redirect('adminhtml/system_config/edit/section/embeds_options/');
    }
}