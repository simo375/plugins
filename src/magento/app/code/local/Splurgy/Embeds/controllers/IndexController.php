<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/TemplateGenerator.php');

class Splurgy_Embeds_IndexController extends Mage_Adminhtml_Controller_Action {        
    protected $splurgyPowerSwitchStateModel;
    private $_templateGenerator;
    private $_path;

    public function _construct() {
        parent::_construct();
        $this->_templateGenerator = new TemplateGenerator();
        $this->_path = Mage::getBaseDir('app'). '/code/local/Splurgy/Embeds/controllers/templates/';
        $this->_templateGenerator->setPath($this->_path);
        $this->splurgyPowerSwitchStateModel  = Mage::getModel('Splurgy_Embeds_Model_PowerSwitchState');
        

    }

    public function checkoutoffAction() {
        $this->splurgyPowerSwitchStateModel->turnOff('checkout');
        
        $this->_redirect("splurgy/index/settings");        
    }


    public function checkoutonAction() {
        $this->splurgyPowerSwitchStateModel->turnOn('checkout');
        $this->_redirect('splurgy/index/settings/');
    }
    
    public function currentAction() {
        return $this->splurgyPowerSwitchStateModel->getState('checkout');
    }

    public function settingsAction()
    {
        $url = Mage::helper("adminhtml")->getUrl("splurgy/index/checkouton");
        $this->loadLayout()->_setActiveMenu('splurgy/settings');
        $powerSwitchState = $this->splurgyPowerSwitchStateModel->getState('checkout');
        //var_dump($url);
        //var_dump($powerSwitchState);
        $state = $powerSwitchState;

        $checked = '';
        if($powerSwitchState == 'on') {
            $checked = "checked='checked'";
            $url = Mage::helper("adminhtml")->getUrl("splurgy/index/checkoutoff");
        }
        //var_dump($checked);
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