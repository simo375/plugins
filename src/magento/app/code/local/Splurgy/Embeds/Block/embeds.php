<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/SplurgyEmbed.php');

class Splurgy_Embeds_Block_Embeds extends Mage_Core_Block_Template
{	

    protected function _construct()
    {
        parent::_construct();
        var_dump("test");
    }

    public function getToken() {
    	var_dump("getToken test");
        // Get token from token.config
        return 'This is working';
    }

    public function getAnalyticsEmbed() {
    	var_dump("getAnalyticsEmbed test");
    	$splurgyEmbed = new SplurgyEmbed;
    	return $splurgyEmbed->getEmbed('analytics')->getTemplate();
    }
}