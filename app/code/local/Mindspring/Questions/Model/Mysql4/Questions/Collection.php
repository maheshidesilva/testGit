<?php
class Mindspring_Questions_Model_Mysql4_Questions_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('questions/questions');
	}
}