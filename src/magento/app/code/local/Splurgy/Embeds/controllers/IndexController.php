<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/TemplateGenerator.php');

class Splurgy_Embeds_IndexController extends Mage_Adminhtml_Controller_Action {        
    protected $_splurgyPowerSwitchStateModel;
    private $_templateGenerator;
    private $_path;

    public function _construct() 
    {
        parent::_construct();
        $this->_templateGenerator = new TemplateGenerator();
        $this->_path = dirname(__FILE__). '/templates/';
        Mage::log($this->_path, null, splurgy_path.log);
        $this->_templateGenerator->setPath($this->_path);
        $this->_splurgyPowerSwitchStateModel 
                = Mage::getModel('Splurgy_Embeds_Model_PowerSwitchState');
    }

    public function checkoutoffAction() 
    {
        $this->_splurgyPowerSwitchStateModel->turnOff('checkout');
        
        $this->_redirect("embeds/index/settings");        
    }


    public function checkoutonAction() 
    {
        $this->_splurgyPowerSwitchStateModel->turnOn('checkout');
        $this->_redirect('embeds/index/settings/');
    }
    
    public function currentAction() 
    {
        return $this->_splurgyPowerSwitchStateModel->getState('checkout');
    }

    public function settingsAction()
    {
        $url = Mage::helper("adminhtml")->getUrl("embeds/index/checkouton");
        $this->loadLayout()->_setActiveMenu('splurgy/settings');
        
        $this->renderLayout();
        

    }
}