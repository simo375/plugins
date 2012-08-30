<?php
 
class Splurgy_Embeds_Model_Observer
{
    /**
     * Flag to stop observer executing more than once
     *
     * @var static bool
     */
    static protected $_singletonFlag = false;
    
    protected $_offerid;
    
    

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
                $customFieldValue =  $this->_getRequest()->getPost('custom-field');
                $model = Mage::getModel('embeds/embeds');
                //Mage::log($customFieldValue, null, 'splurgy-test.log');
                
                $collection = Mage::getModel('catalog/product')->getCollection()
                    ->addAttributeToSelect('*');
                $embeds = Mage::getModel('embeds/embeds')->getCollection();
                $boolean=true;
                $test=$product->getEntityId();
                    foreach ($embeds as $offer){
                        $data = $offer->getData();
                        $entityId = $data["entityid"];
                        if($test-1 == $entityId-1){
                            $boolean=false;
                            $model->load($entityId-1);
                            $model->setTitle($product->getName());
                            $model->setOfferid($customFieldValue);
                            $model->save();
                        }
                    }
                if($boolean){
                    $this->_offerid = Mage::getModel('embeds/embeds');
                    $this->_offerid->setTitle($product->getName());
                    $this->_offerid->setEntityid($product->getEntityId());
                    $this->_offerid->setOfferid($customFieldValue);
                    $this->_offerid->save();
                }
                
              
               
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
    }
    
    public function getOfferID()
    {
        $offerid = Mage::getModel('embeds/embeds')->load(3);
        return $offerid->getEntityid();
    }
    public function getID()
    {
        $offerid = Mage::getModel('embeds/embeds')->load(3);
        $collection = $offerid;
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