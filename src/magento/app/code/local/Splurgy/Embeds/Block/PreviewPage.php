<?php
require_once(Mage::getBaseDir('lib') . '/splurgy-lib/SplurgyEmbed.php');

class Splurgy_Embeds_Block_PreviewPage extends Mage_Adminhtml_Block_System_Config_Form_Field 
{
    protected $splurgyEmbed;

    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('splurgy/preview.phtml');
        $this->splurgyEmbed = new SplurgyEmbed;
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        return $this->_toHtml();
    }

    public function getAnalyticsEmbed() {
        return $this->splurgyEmbed->getEmbed('analytics')->getTemplate();
    }

    public function getPreviewEmbed() {
        return $this->splurgyEmbed->getEmbed('settings-preview')->getTemplate();
    }
    
}
?>
