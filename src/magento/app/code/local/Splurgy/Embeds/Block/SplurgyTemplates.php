<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/SplurgyEmbed.php');

class Splurgy_Embeds_Block_SplurgyTemplates extends Mage_Core_Block_Template
{   
    protected $splurgyEmbed;
    protected $splurgyPowerSwitchState;

    public function _construct() {
	parent::_construct();
	$this->splurgyEmbed = new SplurgyEmbed;
        $this->splurgyPowerSwitchState  = Mage::getModel('Splurgy_Embeds_Model_PowerSwitchState');
    }
    public function getToken() {
        return $this->splurgyEmbed->getToken();
    }

    public function getAnalyticsEmbed() {
        return $this->splurgyEmbed->getEmbed('analytics')->getTemplate();
    }

    public function getOffersEmbed() {
        $entityId = Mage::registry('current_product')->getId();
        $embeds = Mage::getModel('embeds/embeds')->getCollection()
            ->addFilter('entityid', $entityId)
            ->addFilter('status', '1');
        foreach ($embeds as $product){
            return $this->splurgyEmbed->getEmbed('offers', $product->getOfferid())->getTemplate();
               
            }
    }
    
    public function getButtonEmbed() {
        if($this->splurgyPowerSwitchState->getState('checkout')=='on'){
            return $this->splurgyEmbed->getEmbed('button')->getTemplate();
        }
    }
}