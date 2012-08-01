<?php
class Splurgy_Embeds_IndexController extends Mage_Adminhtml_Controller_Action {        

    public function settingsAction()
    {

        $this->loadLayout()->_setActiveMenu('splurgy/settings');

        //create a text block with the name of "example-block"
        $block = $this->getLayout()
        ->createBlock('core/text', 'example-block')
        ->setText('<h1>This is a text </h1>');

        $this->_addContent($block);
        $this->renderLayout();

    }
}