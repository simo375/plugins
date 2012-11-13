<?php
    
    class Splurgy_Embeds_Adminhtml_BannerController extends Mage_Adminhtml_Controller_Action{
        public function indexAction() 
        {
            $this->loadLayout()
            ->_setActiveMenu('embeds/splurgybanner')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'));

            $this->_addContent(
                $this->getLayout()
                ->createBlock('embeds/adminhtml_banner_edit')
            );

            $this->renderLayout();
        }
        
        public function editAction()
        {
            $bannerModel  = Mage::getModel('embeds/banner');
            //Mage::register('embeds_data', $bannerModel);
            $this->loadLayout();
            $this->_setActiveMenu('embeds/splurgybanner');
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')
                ->__('Item Manager'), 
                Mage::helper('adminhtml')->__('Item Manager')
            );
            $this->_addBreadcrumb(
                Mage::helper('adminhtml')
                ->__('Item News'), Mage::helper('adminhtml')
                ->__('Item News')
            );
            
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
            
            $this->_addContent(
                $this->getLayout()
                    ->createBlock('embeds/adminhtml_banner_edit')
            );
            
            $this->renderLayout();
        }
        
        public function saveAction()
        {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $paramEntityId = 1; //$this->getRequest()->getParam('id');
                $splurgyBannerModel = Mage::getModel('embeds/banner')
                        ->getCollection()
                ->addFilter('entityid', $paramEntityId);
                $offerExists = false;
                //if(!ctype_digit($postData['offerid'])){
                //    throw new Exception('Only Numbers Allowed');
                //}
            
                $bannerModel = Mage::getModel('embeds/banner');
                
                foreach ($splurgyBannerModel as $offer) {
                    $data = $offer->getData();
                    $entityid = $data["entityid"];
                    if ($paramEntityId == $entityid) {
                        $offerExists = true;
                        $bannerModel->load($offer->getId());
                        $bannerModel->setStatus($postData['status']);
                        $bannerModel->setOfferid($postData['offerid']);
                        $bannerModel->setBannerimage($postData['bannerimage']);
                        $bannerModel->save();
                    }
                }
                
                if ($offerExists == false) {
                    $bannerModel//->setId($this->getRequest()->getParam('id'))
                    ->setTitle($postData['title'])
                    ->setStatus($postData['status'])
                    ->setOfferid($postData['offerid'])
                    ->setBannerimage($postData['bannerimage'])
                    ->setEntityid($paramEntityId)
                    ->save();
                }
             
                
                Mage::getSingleton('adminhtml/session')
                    ->addSuccess(
                        Mage::helper('adminhtml')
                        ->__('Item was successfully saved')
                    );
                Mage::getSingleton('adminhtml/session')->setEmbedsData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')
                        ->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')
                        ->setEmbedsData($this->getRequest()->getPost());
                $this->_redirect(
                    '*/*/edit', 
                    array('id' => $this->getRequest()->getParam('id'))
                );
            }
        }
        $this->_redirect('*/*/');
        }
        
        public function deleteAction()
        {
            if ($this->getRequest()->getParam('id') > 0 ) {
                try {
                    $bannerModel = Mage::getModel('embeds/banner');
                    
                    $bannerModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                    
                    Mage::getSingleton('adminhtml/session')
                            ->addSuccess(
                                Mage::helper('adminhtml')
                            ->__('Item was successfully deleted')
                            );
                    $this->_redirect('*/*/');
                } catch (Exception $e) {
                    Mage::getSingleton('adminhtml/session')
                            ->addError($e->getMessage());
                    $this->_redirect(
                        '*/*/edit', 
                        array('id' => $this->getRequest()->getParam('id'))
                    );
                }
            }
            $this->_redirect('*/*/');
        }
        /**
         * Product grid for AJAX request.
         * Sort and filter result for example.
         */
        
        public function gridAction()
        {
            $this->loadLayout();
            $this->getResponse()->setBody(
                $this->getLayout()
                    ->createBlock('importedit/adminhtml_banner_grid')
                    ->toHtml()
            );
        }
        
    }