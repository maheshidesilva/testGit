<?php
class Mindspring_Questions_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{
		/*this is retriew data from the database*/
		$questions_id = $this->getRequest()->getParam('id');
		if($questions_id != null && $questions_id != '') {
			$questions = Mage::getModel('questions/questions')->load($questions_id)->getData();
		} else {
			$questions = null;
		}
		if($questions == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$questionsTable = $resource->getTableName('questions');
			$select = $read->select()->from($questionsTable,array('questions_id','questions_description','questions_location','status'))->where('status', 1)->order('created_time DESC') ;
			$questions = $read->fetchRow($select);
		}
		Mage::register('questions', $questions);
		/*this is retriew data from the database  END*/
		$this->loadLayout();
		$this->renderLayout();
	}
}