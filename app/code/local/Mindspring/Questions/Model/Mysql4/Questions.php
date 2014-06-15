<?php
class Mindspring_Questions_Model_Mysql4_Questions extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('questions/questions', 'questions_id');
	}
}