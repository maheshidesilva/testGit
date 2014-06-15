<?php
class Mindspring_Questions_Block_Adminhtml_Questions extends Mage_Adminhtml_Block_Widget_Grid_Container
{

	public function __construct()
	{
		$this->_controller = 'adminhtml_questions';
		$this->_blockGroup = 'questions';
		$this->_headerText = Mage::helper('questions')->__('Item Manager');
		$this->_addButtonLabel = Mage::helper('questions')->__('Add Brand');
		parent::__construct();
	}
}