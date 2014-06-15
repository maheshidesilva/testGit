<?php
class Mindspring_Questions_Block_Form extends Mage_Core_Block_Template
{
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
                $data->setName($customer->getFirstname());
                $data->setEmail($customer->getEmail());
            }
        }

        $this->setAllowWriteReviewFlag($customerSession->isLoggedIn() || Mage::helper('review')->getIsGuestAllowToWrite());
        if (!$this->getAllowWriteReviewFlag) {
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

	public function getProductInfo()
    {
        $product = Mage::getModel('catalog/product');
        return $product->load($this->getRequest()->getParam('id'));
    }
    
	public function getAction()
    {
        $productId = Mage::app()->getRequest()->getParam('id', false);
        return Mage::getUrl('questions/questions/post', array('id' => $productId));
    }
}