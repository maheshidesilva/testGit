<?php
class Mindspring_Questions_Model_Questions extends Mage_Core_Model_Abstract
{
	protected $_eventPrefix = 'questions';
	
	const ENTITY_PRODUCT_CODE   = 'product';
    const ENTITY_CUSTOMER_CODE  = 'customer';
    const ENTITY_CATEGORY_CODE  = 'category';

    const STATUS_APPROVED       = 1;
    const STATUS_PENDING        = 2;
    const STATUS_NOT_APPROVED   = 3;
    
	public function _construct()
	{
		parent::_construct();
		$this->_init('questions/questions');
	}
	
	public function validate()
	{
		return true;
	}
	
}