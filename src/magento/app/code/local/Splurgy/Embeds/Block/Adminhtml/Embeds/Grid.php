<?php
 
class Splurgy_Embeds_Block_Adminhtml_Embeds_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('embedsGrid');
        // This is the primary key of the database
        $this->setDefaultSort('embeds_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('embeds/embeds')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('embeds_id', array(
            'header'    => Mage::helper('embeds')->__('ID'),
            'align'     => 'right',
            'width'     => '50px',
            'index'     => 'embeds_id',
        ));
  
        $this->addColumn('title', array(
            'header'    => Mage::helper('embeds')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));
        
        /*
        $this->addColumn('content', array(
            'header'    => Mage::helper('embeds')->__('Item Content'),
            'width'     => '150px',
            'index'     => 'content',
        ));
        */
      
        $this->addColumn('offerid', array(
            'header'    => Mage::helper('embeds')->__('OfferID'),
            'align'     => 'left',
            'width'     => '120px',
            'index'     => 'offerid',
        ));
        
 
        $this->addColumn('created_time', array(
            'header'    => Mage::helper('embeds')->__('Creation Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'created_time',
        ));
 
        $this->addColumn('update_time', array(
            'header'    => Mage::helper('embeds')->__('Update Time'),
            'align'     => 'left',
            'width'     => '120px',
            'type'      => 'date',
            'default'   => '--',
            'index'     => 'update_time',
        ));   
 
 
        $this->addColumn('status', array(
 
            'header'    => Mage::helper('embeds')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));
 
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
 
 
}
