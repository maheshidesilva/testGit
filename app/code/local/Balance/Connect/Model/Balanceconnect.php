<?php
class Balance_Connect_Model_Balanceconnect extends Varien_Object {
	
	/**
	 * The API object to make calls on
	 * @var api
	 */
	var $api;
	
	/**
	 * API User
	 * @var string
	 */
	var $usr;
	
	/**
	 * API Pass
	 * @var string
	 */
	 var $pass;
	 
	
	
	function __construct()
	{
		
	}
	
	/*----------------- BEGIN API CALL METHODS -------------------------//	
	 Some methods require things like XML input in a special format, 
		so they make use of utility methods in this class, taking a regular
		Magento object to make it easier for other extensions to interface
		with this extension
	---------------------------------------------------------------------*/
	
	/**
	 * Get the balance for a gift card as a decimal
	 * 
	 * @param string $voucherNumber
	 * @param boolean	$requirePin
	 * @param string $pin (optional)
	 * @throws Exception for invalid giftcard	
	 * @return double Gift card balance (eg: $500 gift card would return: 500.0000)
	 */
	public function getGiftCardBalance($voucherNumber, $requirePin, $pin='')
	{
		try
		{

			if($pin==9999)
			{				
				 throw new Exception("Error blah blah");
			} else {
				$retVal = "20.0000";
			}
		}
		catch(Exception $ex)
		{
			Mage::log($ex, null, 'balance_connect.log');
			throw new Exception("Error retrieving giftcard balance. Invalid giftcard");
		}
		return $retVal;	
	}
	
  }
?>
