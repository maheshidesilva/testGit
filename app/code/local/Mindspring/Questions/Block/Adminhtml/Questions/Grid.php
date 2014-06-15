<?php
class Mindspring_Questions_Block_Adminhtml_Questions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('questionsGrid');
		$this->setDefaultSort('questions_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}
	protected function _prepareCollection()
	{
		$collection = Mage::getModel('questions/questions')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	protected function _prepareColumns()
	{
		$this->addColumn('questions_id', array(
		'header' => Mage::helper('questions')->__('ID'),
		'align' =>'right',
		'width' => '50px',
		'index' => 'questions_id',
		));
		$this->addColumn('title', array(
		'header' => Mage::helper('questions')->__('Title'),
		'align' =>'left',
		'index' => 'title',
		));
		$this->addColumn('status', array(
		'header' => Mage::helper('questions')->__('Status'),
		'align' => 'left',
		'width' => '80px',
		'index' => 'status',
		'type' => 'options',
		'options' => array(
		1 => 'Enabled',
		2 => 'Disabled',
		),
		));
		$this->addColumn('action',
		array(
		'header' => Mage::helper('questions')->__('Action'),
		'width' => '100',
		'type' => 'action',
		'getter' => 'getId',
		'actions' => array(
		array(
		'caption' => Mage::helper('questions')->__('Edit'),
		'url' => array('base'=> '*/*/edit'),
		'field' => 'id'
		)
		),
		'filter' => false,
		'sortable' => false,
		'index' => 'stores',
		'is_system' => true,
		));
		return parent::_prepareColumns();
	}
	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}
}