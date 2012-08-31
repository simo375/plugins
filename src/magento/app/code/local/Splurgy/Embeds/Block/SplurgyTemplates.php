<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/SplurgyEmbed.php');

class Splurgy_Embeds_Block_SplurgyTemplates extends Mage_Core_Block_Template
{   
    protected $splurgyEmbed;
    protected $splurgyPowerSwitchState;
    protected $splurgyOfferIDState;

    public function _construct() {
       parent::_construct();
       $this->splurgyEmbed = new SplurgyEmbed;
       $this->splurgyPowerSwitchState  = Mage::getModel('Splurgy_Embeds_Model_PowerSwitchState');
       $this->splurgyOfferIDState = Mage::getModel('embeds/embeds')->load(4);

    }
    public function getToken() {
        return $this->splurgyEmbed->getToken();
    }

    public function getAnalyticsEmbed() {
        return $this->splurgyEmbed->getEmbed('analytics')->getTemplate();
    }

    public function getOffersEmbed() {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('*');
        $embeds = Mage::getModel('embeds/embeds')->getCollection();
        foreach ($collection as $product) {
            $test=$product->getEntityId();
            foreach ($embeds as $product){
                $data = $product->getData();
                $entityId = $data["entityid"];
                if($test == $entityId && $product->getStatus()=='1'){
                    return $this->splurgyEmbed->getEmbed('offers', '340')->getTemplate();
                }
            }
        }
        //if($this->splurgyOfferIDState->getStatus() == '1'){
        //    return $this->splurgyEmbed->getEmbed('offers', '340')->getTemplate();
        //}
        var_dump($this->splurgyOfferIDState->getStatus());
    }
    
    public function getButtonEmbed() {
        if($this->splurgyPowerSwitchState->getState('checkout')=='on'){
            return $this->splurgyEmbed->getEmbed('button')->getTemplate();
        }
    }
}