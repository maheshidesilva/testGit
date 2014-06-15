<?php
class Mindspring_Questions_Block_Questions extends Mage_Core_Block_Template
{
	public function _prepareLayout()
	{
		return parent::_prepareLayout();
	}
	public function getQuestions()
	{	
		return Mage::registry('questions');
	}
	
	public function __construct()
    {
        $customerSession = Mage::getSingleton('customer/session');

        parent::__construct();

        $data =  Mage::getSingleton('questions/session')->getFormData(true);
        $data = new Varien_Object($data);

        // add logged in customer name as nickname
        if (!$data->getNickname()) {
            $customer = $customerSession->getCustomer();
            if ($customer && $customer->getId()) {
                $data->setNickname($customer->getFirstname());
            }
        }

        $this->setAllowWriteReviewFlag($customerSession->isLoggedIn() || Mage::helper('questions')->getIsGuestAllowToWrite());
        if (!$this->getAllowWriteQuestionsFlag) {
            $this->setLoginLink(
                Mage::getUrl('customer/account/login/', array(
                    Mage_Customer_Helper_Data::REFERER_QUERY_PARAM_NAME => Mage::helper('core')->urlEncode(
                        Mage::getUrl('*/*/*', array('_current' => true)) .
                        '#questions-form')
                    )
                )
            );
        }

        $this->setTemplate('questions/form.phtml')
            ->assign('data', $data)
            ->assign('messages', Mage::getSingleton('questions/session')->getMessages(true));
    }
	
}
