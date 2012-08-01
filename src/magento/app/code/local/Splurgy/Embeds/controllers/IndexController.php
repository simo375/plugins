<?php
class Splurgy_Embeds_IndexController extends Mage_Adminhtml_Controller_Action {        

    public function settingsAction()
    {

        $this->loadLayout()->_setActiveMenu('splurgy/settings');

        //create a text block with the name of "example-block"
        $block = $this->getLayout()
        ->createBlock('core/text', 'example-block')
        ->setText(
            "<h4>Turn on or off the offer on the checkout page. </h4>
            <div class='offerPowerSwitch'>
                <input type='checkbox' id='offerPowerSwitch' />
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