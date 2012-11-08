<?php
    
    class Splurgy_Embeds_Model_Banner extends Mage_Core_Model_Abstract
    {
        public function _construct()
        {
            parent::_construct();
            $this->_init('embeds/banner');
        }
    }
