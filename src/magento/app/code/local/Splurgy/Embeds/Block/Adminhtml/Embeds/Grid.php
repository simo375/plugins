<?php
 
class Splurgy_Embeds_Block_Adminhtml_Embeds_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('embedsGrid');
        // This is the primary key of the database
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToSelect('name');
        $collection->addAttributeToSelect('offerid');
        $collection->getSelect()
                ->joinLeft( array('ce1' => 'splurgy_embed'), 'ce1.entityid=entity_id', array('offerid' => 'offerid'))
                ->joinLeft(array('ce2' => 'splurgy_embed'), 'ce2.entityid=entity_id', array('status' => 'status'));
        
        $this->setCollection($collection);
        parent::_prepareCollection();
    }
    
    protected function _addColumnFilterToCollection($column)
    {
        if ($this->getCollection()) {
            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField('websites',
                    'catalog/product_website',
                    'website_id',
                    'product_id=entity_id',
                    null,
                    'left');
            }
        }
        return parent::_addColumnFilterToCollection($column);
    }

 
    protected function _prepareColumns()
    {
        $this->addColumn('entity_id',
            array(
                'header'=> Mage::helper('catalog')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'entity_id',
        ));
        $this->addColumn('name',
            array(
                'header'=> Mage::helper('catalog')->__('Product'),
                'index' => 'name',
        ));
        
        $this->addColumn('offerid', array(
            'header'    => Mage::helper('catalog')->__('Offer ID'),
            'width'     => '150px',
            'index'     => 'offerid',
        ));
         
        $this->addColumn('status', array(
 
            'header'    => Mage::helper('catalog')->__('Offer ID Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'status',
            'type'      => 'options',
            'options'   => array(
                1 => 'Active',
                0 => 'Inactive',
            ),
        ));
        echo 'How To: Simply click on the product you want to add a Splurgy Offer to. Once in the Edit page, enter in the offerID and change the status.';
        return parent::_prepareColumns();
        
        
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
 
 
}
