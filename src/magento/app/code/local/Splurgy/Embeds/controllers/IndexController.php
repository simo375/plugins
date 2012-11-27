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
    }

    public function checkoutoffAction() 
    {
        $this->_redirect("embeds/index/settings");        
    }

    public function checkoutonAction() 
    {
        $this->_redirect('embeds/index/settings/');
    }
    
    public function currentAction() 
    {
        return $this->_splurgyPowerSwitchStateModel->getState('checkout');
    }

    public function settingsAction()
    {
        $this->loadLayout()->_setActiveMenu('splurgy/settings');
        
        $this->renderLayout();
        

    }
}