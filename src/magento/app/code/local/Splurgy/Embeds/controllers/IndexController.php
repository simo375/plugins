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
        $iphonejs = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_JS).'splurgyjs/iphone-style-checkboxes/iphone-style-checkboxes.js';
        var_dump($iphonejs);
        $this->loadLayout()->_setActiveMenu('splurgy/settings');

        $powerSwitchState = $this->splurgyPowerSwitchStateModel->getState('checkout');

        $checked = '';
        if($powerSwitchState == 'on') {
            $checked = "checked='checked'";
            $url = Mage::helper("adminhtml")->getUrl("splurgy/index/checkoutoff");
        }
        $this->_templateGenerator->setTemplateName('powerswitch');
        $this->_templateGenerator->setPatterns(array('{$iphonejs}', '{$checked}', '{$url}'));
        $this->_templateGenerator->setReplacements(array($iphonejs, $checked, $url));
        $checkoutPowerswitch = $this->getLayout()
            ->createBlock('core/text', 'checkoutPowerswitch')
            ->setText($this->_templateGenerator->getTemplate());

        $this->_addContent($checkoutPowerswitch);
        $this->renderLayout();
        

    }
}