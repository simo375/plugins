<?php
 
class Splurgy_Embeds_Model_Observer
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
    public function copyingData()
    {
        $query = 'INSERT INTO splurgy_embed (entityid)'.
                'SELECT catalog_product_entity.entity_id'. 
                'FROM catalog_product_entity'; 
	 
        $result = mysql_query($query) or die(mysql_error());
        
    }
    
    public function saveProductTabData(Varien_Event_Observer $observer)
    {

        if (!self::$_singletonFlag) {
            self::$_singletonFlag = true;
 
            $product = $observer->getEvent()->getProduct();
            //Mage::log($product, null, 'splurgy-test.log');
            try {
                $customFieldValue =  $this->_getRequest()->getPost('custom-field');
                //Mage::log($customFieldValue, null, 'splurgy-test.log');
                /**
                 * Uncomment the line below to save the product
                 *
                 */
                $model = Mage::getModel('embeds/embeds');
                $offerid = Mage::getModel('embeds/embeds');
                    $offerid->setTitle($product->getName());
                    $offerid->setEntityid($product->getEntityId());
                    $offerid->setOfferid($customFieldValue);
                    $offerid->save();
               
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
    }
    public function getOfferID()
    {
        //$productID = getProduct()->getCategoryId();
        //return $productID;
    }
    public function getID()
    {
        $offerid = Mage::getModel('embeds/embeds')->load(1);
        $collection = $offerid->getCollection();
        return $collection;
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