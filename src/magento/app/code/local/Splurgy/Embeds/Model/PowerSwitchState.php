<?php

class Splurgy_Embeds_Model_PowerSwitchState extends Mage_Core_Model_Config_Data
{

	protected $mageConfig;

	public function _construct() {
		parent::_construct();
		$this->mageConfig = new Mage_Core_Model_Config();
	}

	public function turnOn($powerswitchName) {
		$this->mageConfig->saveConfig("splurgy/power_switch/$powerswitchName", "on", 'default', 0);
	}
		
	public function turnOff($powerswitchName) {
		$this->mageConfig->saveConfig("splurgy/power_switch/$powerswitchName", "off", 'default', 0);
	}
		
	public function getState($powerswitchName) {
		return Mage::getStoreConfig("splurgy/power_switch/$powerswitchName");
	}
}