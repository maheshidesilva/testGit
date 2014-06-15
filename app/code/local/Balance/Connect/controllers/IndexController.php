<?php
class Balance_Connect_IndexController extends Mage_Core_Controller_Front_Action
{
   public function indexAction()
   {
   	echo "Welcome to Balance Connect<br />";
   	
   	$model = Mage::getModel('connect/balanceconnect');
   	var_dump($model->getGiftCardBalance("GC0000000000000501617845","true","7845"));
   	
   }
   
}
?>