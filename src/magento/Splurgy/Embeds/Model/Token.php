<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/SplurgyEmbed.php');

class Splurgy_Embeds_Model_Token extends Mage_Core_Model_Config_Data
{

	private $_splurgyEmbed;

	public function _construct() {
		$this->_splurgyEmbed = new SplurgyEmbed;
		parent::_construct();
	}

	public function save() {
		try {
			$this->_splurgyEmbed->setToken($this->getValue());
			Mage::getSingleton('core/session')->addSuccess('Successfully saved token!');
		} catch(TokenErrorException $splurgyException) {
			Mage::throwException($splurgyException->getMessage()); 
		}
	}



}