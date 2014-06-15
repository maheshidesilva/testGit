<?php
class Mindspring_Questions_Block_Adminhtml_Questions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	public function __construct()
	{
		parent::__construct();
		$this->_objectId = 'id';
		$this->_blockGroup = 'questions';
		$this->_controller = 'adminhtml_questions';
		$this->_updateButton('save', 'label', Mage::helper('questions')->__('Save Brand'));
		$this->_updateButton('delete', 'label', Mage::helper('questions')->__('Delete Brand'));
	}
	public function getHeaderText()
	{
		if( Mage::registry('questions_data') && Mage::registry('questions_data')->getId() ) {
			return Mage::helper('questions')->__("Edit Brand '%s'", $this->htmlEscape(Mage::registry('questions_data')->getTitle()));
		} else {
			return Mage::helper('questions')->__('Add Brand');
	}
	}
}