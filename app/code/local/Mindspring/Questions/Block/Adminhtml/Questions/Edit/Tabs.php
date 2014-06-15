<?php
class Mindspring_Questions_Block_Adminhtml_Questions_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('questions_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('questions')->__('Brand Information'));
	}
	protected function _beforeToHtml()
	{
		$this->addTab('form_section', array(
		'label' => Mage::helper('questions')->__('Brand Information'),
		'title' => Mage::helper('questions')->__('Brand Information'),
		'content' => $this->getLayout()->createBlock('questions/adminhtml_questions_edit_tab_form')->toHtml(),
		));
		return parent::_beforeToHtml();
	}
}