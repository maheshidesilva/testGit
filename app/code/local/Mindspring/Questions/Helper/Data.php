<?php
class Mindspring_Questions_Helper_Data extends Mage_Core_Helper_Abstract
{
	const XML_QUESTIONS_GUETS_ALLOW = 'catalog/questions/allow_guest';

    public function getDetail($origDetail){
        return nl2br(Mage::helper('core/string')->truncate($origDetail, 50));
    }
    
	public function getDetailHtml($origDetail){
        return nl2br(Mage::helper('core/string')->truncate($this->escapeHtml($origDetail), 50));
    }

    public function getIsGuestAllowToWrite()
    {
        return Mage::getStoreConfigFlag(self::XML_QUESTIONS_GUETS_ALLOW);
    }
}