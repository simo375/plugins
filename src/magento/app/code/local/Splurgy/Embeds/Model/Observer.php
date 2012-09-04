<?php
 
class Splurgy_Embeds_Model_Observer
{
    /**
     * Flag to stop observer executing more than once
     *
     * @var static bool
     */
    
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
 
            $product = $observer->getEvent()->getProduct();
            //Mage::log($product, null, 'splurgy-test.log');
            try {
                $model = Mage::getModel('embeds/embeds');
                //Mage::log($customFieldValue, null, 'splurgy-test.log');
                $productId=$product->getId();
                Mage::log($productId, null, 'splurgy-test.log');
                $embeds = Mage::getModel('embeds/embeds')->getCollection()
                        ->addFilter('entityid', $productId);
                    
         
                $boolean=false;

                foreach ($embeds as $offer){
                    $data = $offer->getData();
                    Mage::log("GetData: ". $data, null, 'splurgy-observer.log');
                    $entityid = $data["entityid"];
                    if($productId == $entityid && $entityid != null){
                        $boolean=true;
                        $model->load($offer->getId());
                        $model->setTitle($product->getName());
                        Mage::log("Entity ID: ". ($entityid-1), null, 'splurgy-observer.log');
                        Mage::log("Foreach: ". $boolean, null, 'splurgy-observer.log');
                        $model->save();

                    }
                }
                if($boolean==false ){
                    $this->_offerid = Mage::getModel('embeds/embeds');
                    $this->_offerid->setTitle($product->getName());
                    $this->_offerid->setEntityid($product->getEntityId());
                    Mage::log("if: ".$boolean, null, 'splurgy-observer.log');
                    $this->_offerid->save();
                }
                
            
              
               
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
    }
    
    public function getOfferID()
    {
        $offerid = Mage::getModel('embeds/embeds')->load(3);
        return $offerid->getOfferid();
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