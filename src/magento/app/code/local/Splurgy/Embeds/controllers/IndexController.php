<?php
class Splurgy_Embeds_IndexController extends Mage_Adminhtml_Controller_Action {        
    protected $splurgyPowerSwitchStateModel;

    public function _construct() {
        parent::_construct();
        $this->splurgyPowerSwitchStateModel  = Mage::getModel('Splurgy_Embeds_Model_PowerSwitchState');
        

    }

    public function checkoutoffAction() {
        $this->splurgyPowerSwitchStateModel->turnOff('checkout');
        $this->_redirect('splurgy/index/setttings/');
    }


    public function checkoutonAction() {
        $this->splurgyPowerSwitchStateModel->turnOn('checkout');
        $this->_redirect('splurgy/index/setttings/');
    }

    public function settingsAction()
    {

        $this->loadLayout()->_setActiveMenu('splurgy/settings');
        $powerSwitchState = $this->splurgyPowerSwitchStateModel->getState('checkout');
        $checked = '';
        if($powerSwitchState == 'on') {
            $checked = "checked='checked'";
        }
        

        $block = $this->getLayout()
        ->createBlock('core/text', 'example-block')
        ->setText(
            "<h4>Turn on or off the offer on the checkout page. </h4>
            <div class='offerPowerSwitch'>
                <input type='checkbox' $checked id='offerPowerSwitch' />
            </div>
            <script type='text/javascript'>
                new iPhoneStyle('.offerPowerSwitch input[type=checkbox]', {
                    checkedLabel: 'ON',
                    uncheckedLabel: 'OFF'
                });
            </script>"
                );

        $this->_addContent($block);
        $this->renderLayout();

    }
}