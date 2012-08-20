<?php
 
class Splurgy_Embeds_Model_Observer //extends Mage_Adminhtml_Catalog_ProductController
{
    /**
     * Flag to stop observer executing more than once
     *
     * @var static bool
     */
    static protected $_singletonFlag = false;
 
    /**
     * This method will run when the product is saved from the Magento Admin
     * Use this function to update the product model, process the
     * data or anything you like
     *
     * @param Varien_Event_Observer $observer
     */
    //public function _construct() {
    //    parent::_construct();
    //}
    public function saveProductTabData(Varien_Event_Observer $observer)
    {
        if (!self::$_singletonFlag) {
            self::$_singletonFlag = true;
 
            $product = $observer->getEvent()->getProduct();
            //Mage::log($product, null, 'splurgy-test.log');
            try {
                /**
                 * Perform any actions you want here
                 *
                 */
                $customFieldValue =  $this->_getRequest()->getPost('custom-field');
                Mage::log($customFieldValue, null, 'splurgy-test.log');
                /**
                 * Uncomment the line below to save the product
                 *
                 */
                $product->setData($customFieldValue,101);
                $product->save();
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
    }
    
 
    /**
     * Retrieve the product model
     *
     * @return Mage_Catalog_Model_Product $product
     */
    public function getProduct()
    {
        return Mage::registry('product');
    }
 
    /**
     * Shortcut to getRequest
     *
     */
    protected function _getRequest()
    {
        return Mage::app()->getRequest();
    }
}