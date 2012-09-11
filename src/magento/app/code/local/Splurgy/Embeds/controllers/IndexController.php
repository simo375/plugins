<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/TemplateGenerator.php');

class Splurgy_Embeds_IndexController extends Mage_Adminhtml_Controller_Action {        
    protected $splurgyPowerSwitchStateModel;
    private $_templateGenerator;
    private $_path;

    public function _construct() {
        parent::_construct();
        $this->_templateGenerator = new TemplateGenerator();
        $this->_path = dirname(__FILE__). '/templates/';
        Mage::log($this->_path, null, splurgy_path.log);
        $this->_templateGenerator->setPath($this->_path);
        $this->splurgyPowerSwitchStateModel  = Mage::getModel('Splurgy_Embeds_Model_PowerSwitchState');
        

    }

    public function checkoutoffAction() {
        $this->splurgyPowerSwitchStateModel->turnOff('checkout');
        
        $this->_redirect("embeds/index/settings");        
    }


    public function checkoutonAction() {
        $this->splurgyPowerSwitchStateModel->turnOn('checkout');
        $this->_redirect('embeds/index/settings/');
    }
    
    public function currentAction() {
        return $this->splurgyPowerSwitchStateModel->getState('checkout');
    }

    public function settingsAction()
    {
        $url = Mage::helper("adminhtml")->getUrl("embeds/index/checkouton");
        $this->loadLayout()->_setActiveMenu('splurgy/settings');
        $powerSwitchState = $this->splurgyPowerSwitchStateModel->getState('checkout');
        $state = $powerSwitchState;

        $checked = '';
        if($powerSwitchState == 'on') {
            $checked = "checked='checked'";
            $url = Mage::helper("adminhtml")->getUrl("embeds/index/checkoutoff");
        }
        $this->_templateGenerator->setTemplateName('powerswitch');
        $this->_templateGenerator->setPatterns(array('{$checked}', '{$url}', '{$state}'));
        $this->_templateGenerator->setReplacements(array($checked, $url, $state));
        $checkoutPowerswitch = $this->getLayout()
            ->createBlock('core/text', 'checkoutPowerswitch')
            ->setText($this->_templateGenerator->getTemplate());

        $this->_addContent($checkoutPowerswitch);
        $this->renderLayout();
        

    }
}