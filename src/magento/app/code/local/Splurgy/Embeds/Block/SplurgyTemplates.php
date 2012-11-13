<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/SplurgyEmbed.php');

class Splurgy_Embeds_Block_SplurgyTemplates extends Mage_Core_Block_Template {   
    protected $_splurgyEmbed;
    protected $_splurgyPowerSwitchState;

    public function _construct() 
    {
        parent::_construct();
        $this->_splurgyEmbed = new SplurgyEmbed;
        $this->_splurgyPowerSwitchState  
                = Mage::getModel('Splurgy_Embeds_Model_PowerSwitchState');
    }
    public function getToken() 
    {
        return $this->_splurgyEmbed->getToken();
    }

    public function getAnalyticsEmbed() 
    {
        return $this->_splurgyEmbed->getEmbed('analytics')->getTemplate();
    }

    public function getOffersEmbed() 
    {
        $entityId = Mage::registry('current_product')->getId();
        $embeds = Mage::getModel('embeds/embeds')->getCollection()
            ->addFilter('entityid', $entityId)
            ->addFilter('status', '1');
        foreach ($embeds as $product) {
            return $this->_splurgyEmbed
                    ->getEmbed('offers', $product->getOfferid())
                    ->getTemplate();
        }
    }
    
    public function getButtonEmbed() 
    {
        if ($this->_splurgyPowerSwitchState->getState('checkout')==='on') {
            return $this->_splurgyEmbed->getEmbed('button')->getTemplate();
        }
    }
}