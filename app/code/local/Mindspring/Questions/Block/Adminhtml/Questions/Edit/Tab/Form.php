<?php
class Mindspring_Questions_Block_Adminhtml_Questions_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('questions_form', array('legend'=>Mage::helper('questions')->__('Brand information')));
		$fieldset->addField('questions_name', 'text', array(
			'label' => Mage::helper('questions')->__('Brand Name'),
			'class' => 'required-entry',
			'required' => true,
			'name' => 'questions_name',
			));
		$fieldset->addField('status', 'select', array(
			'label' => Mage::helper('questions')->__('Status'),
			'name' => 'status',
			'values' => array(
				array(
				'value' => 1,
				'label' => Mage::helper('questions')->__('Active'),
				),
				array(
				'value' => 0,
				'label' => Mage::helper('questions')->__('Inactive'),
				),
			),
			));
		$fieldset->addField('questions_location', 'text', array(
			'label' => Mage::helper('questions')->__('Location'),
			'class' => 'required-entry',
			'required' => true,
			'name' => 'questions_location',
			));
		$fieldset->addField('questions_description', 'editor', array(
			'name' => 'questions_description',
			'label' => Mage::helper('questions')->__('Description'),
			'title' => Mage::helper('questions')->__('Description'),
			'style' => 'width:98%; height:400px;',
			'wysiwyg' => false,
			'required' => true,
			));
		if ( Mage::getSingleton('adminhtml/session')->getQuestionsData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getQuestionsData());
			Mage::getSingleton('adminhtml/session')->setQuestionsData(null);
		} elseif ( Mage::registry('questions_data') ) {
			$form->setValues(Mage::registry('questions_data')->getData());
		}
			return parent::_prepareForm();
		}
	}
