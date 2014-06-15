<?php
class Mindspring_Questions_Adminhtml_QuestionsController extends Mage_Adminhtml_Controller_action
{
	protected function _initAction()
	{
		$this->loadLayout()
		->_setActiveMenu('questions/items')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Questions Manager'),
		Mage::helper('adminhtml')->__('Questions Manager'));
		return $this;
	}
	
	public function indexAction() {
		$this->_initAction();
		$this->renderLayout();
	}
	
	public function editAction()
	{
		$questionsId = $this->getRequest()->getParam('id');
		$questionsModel = Mage::getModel('questions/questions')->load($questionsId);
		if ($questionsModel->getId() || $questionsId == 0) {
			Mage::register('questions_data', $questionsModel);
			$this->loadLayout();
			$this->_setActiveMenu('questions/items');
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Questions
				Manager'), Mage::helper('adminhtml')->__('Questions Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand
				Description'), Mage::helper('adminhtml')->__('Brand Description'));
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
			$this->_addContent($this->getLayout()->createBlock('questions/adminhtml_questions_edit'))
				->_addLeft($this->getLayout()->createBlock('questions/adminhtml_questions_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('questions')->__('Brand does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	public function newAction()
	{
		$this->_forward('edit');
	}
	
	public function saveAction()
	{
		if ( $this->getRequest()->getPost() ) {
		try {
			$postData = $this->getRequest()->getPost();
			$questionsModel = Mage::getModel('questions/questions');
			if( $this->getRequest()->getParam('id') <= 0 )
			$questionsModel->setCreatedTime(Mage::getSingleton('core/date')->gmtDate());
			$questionsModel	->addData($postData)->setUpdateTime(Mage::getSingleton('core/date')->gmtDate())
				->setId($this->getRequest()->getParam('id'))->save();
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brand was successfully saved'));
			Mage::getSingleton('adminhtml/session')->setQuestionsData(false);
			$this->_redirect('*/*/');
			return;
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			Mage::getSingleton('adminhtml/session')->setQuestionsData($this->getRequest()->getPost());
			$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			return;
		}
		}
		$this->_redirect('*/*/');
	}
	
	public function deleteAction()
	{
		if( $this->getRequest()->getParam('id') > 0 ) {
		try {
			$questionsModel = Mage::getModel('questions/questions');
			$questionsModel->setId($this->getRequest()->getParam('id'))->delete();
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Brand was successfully deleted'));
			$this->_redirect('*/*/');
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
		}
		}
		$this->_redirect('*/*/');
	}
}