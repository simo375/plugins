<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/SplurgyEmbed.php');

class Splurgy_Embeds_Model_Token extends Mage_Core_Model_Config_Data
{

    private $_splurgyEmbed;

    public function _construct() 
    {
    $this->_splurgyEmbed = new SplurgyEmbed;
    parent::_construct();
    }

    public function save() 
    {
        try {
             $this->_splurgyEmbed->setToken($this->getValue());
             parent::save();
             Mage::getSingleton('core/session')
                     ->addSuccess('Successfully saved token!');
        } 
        catch(TokenErrorException $splurgyException) {
            Mage::throwException($splurgyException->getMessage()); 
        }
    }

    public function delete() 
    {
        $this->_splurgyEmbed->deleteToken();
        $mageConfig = new Mage_Core_Model_Config();
        $mageConfig->saveConfig('embeds_options/setup_token/token', "", 'default', 0);
    }
        
        public function getToken() 
        {
                return Mage::getStoreConfig("embeds_options/setup_token/token");
        }


}