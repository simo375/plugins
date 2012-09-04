<?php
 
class Splurgy_Embeds_Adminhtml_EmbedsController extends Mage_Adminhtml_Controller_Action
{
 
    public function indexAction() {
        $this->loadLayout()
            ->_setActiveMenu('embeds/items')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'));       
        $this->renderLayout();
    }
 
    public function editAction()
    {
        $embedsId     = $this->getRequest()->getParam('id');
        $embedsModel  = Mage::getModel('embeds/embeds')->load($embedsId);
 
        if ($embedsModel->getId() || $embedsId == 0) {
 
            Mage::register('embeds_data', $embedsModel);
 
            $this->loadLayout();
            $this->_setActiveMenu('embeds/items');
           
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
           
            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
           
            $this->_addContent($this->getLayout()->createBlock('embeds/adminhtml_embeds_edit'))
                 ->_addLeft($this->getLayout()->createBlock('embeds/adminhtml_embeds_edit_tabs'));
               
            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('embeds')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
   
   
    public function saveAction()
    {
        if ( $this->getRequest()->getPost() ) {
            try {
                $postData = $this->getRequest()->getPost();
                $embedsModel = Mage::getModel('embeds/embeds');
                // Validation of offer id
               // if the $postData['offerid'] not a number
                // throw an Exception('No letters allowed
                if(!ctype_digit($postData['offerid'])){
                    throw new Exception('Only Numbers Allow');
                }
                $embedsModel->setId($this->getRequest()->getParam('id'))
                    ->setTitle($postData['title'])
                    ->setStatus($postData['status'])
                    ->setOfferid($postData['offerid'])
                    ->save();
               
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setEmbedsData(false);
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setEmbedsData($this->getRequest()->getPost());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
   
    public function deleteAction()
    {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $embedsModel = Mage::getModel('embeds/embeds');
               
                $embedsModel->setId($this->getRequest()->getParam('id'))
                    ->delete();
                   
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
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
               $this->getLayout()->createBlock('importedit/adminhtml_embeds_grid')->toHtml()
        );
    }
    
}