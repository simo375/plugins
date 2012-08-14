<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/SplurgyEmbed.php');

class Splurgy_Embeds_Block_SplurgyTemplates extends Mage_Core_Block_Template
{	
    protected $splurgyEmbed;
    protected $splurgyPowerSwitchState;

    public function _construct() {
	parent::_construct();
	$this->splurgyEmbed = new SplurgyEmbed;
        $this->splurgyPowerSwitchStateModel  = Mage::getModel('Splurgy_Embeds_Model_PowerSwitchState');

    }
    public function getToken() {
        return $this->splurgyEmbed->getToken();
    }

    public function getAnalyticsEmbed() {
    	return $this->splurgyEmbed->getEmbed('analytics')->getTemplate();
    }

    public function getOffersEmbed() {
    	return $this->splurgyEmbed->getEmbed('offers', '340')->getTemplate();
    }
    
    public function getButtonEmbed() {
        $powerSwitchState = $this->splurgyPowerSwitchState->getState('checkout');
        if($powerSwitchState == 'on'){
            return $this->splurgyEmbed->getEmbed('button')->getTemplate();
        }
    }
}