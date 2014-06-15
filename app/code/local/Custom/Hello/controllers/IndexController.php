<?php

class Custom_Hello_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $attribute_model        = Mage::getModel('catalog/resource_eav_attribute')
                        ->getCollection();
        var_dump($attribute_model);
    
    /*** this is to change attribute option values programmatically **/
    /* $attribute_model        = Mage::getModel('catalog/resource_eav_attribute');
	$attribute_code         = $attribute_model->getIdByCode('catalog_product', 'shirt_size');
	$attribute              = $attribute_model->load($attribute_code);
	
	$options= $attribute->getSource()->getAllOptions(false) ;
	var_dump($options);var_dump("<br/>");
	$new_options=array();
	foreach($options as $option){
		if($option['label']=='Large')
			{
				$new_options[$option['value']]=array(0=>'XL');
			}else{
				$new_options[$option['value']]=array(0=>$option['label']);
			}
	}
	arsort($new_options);
	
	
	$data = $attribute->getData();
	//var_dump("mahe<br/>");var_dump($data);
	
	
	$code = 'shirt_size'; // attribute code your are trying to get
	$orderby = 'ASC'; // sort order

	// get's attribute, we use this to get the attribute id since this can be 
	// different between installations but if you use install scripts in your modules 
	// the attribute code should be consistent
	$attribute2 = Mage::getModel('eav/entity_attribute')->load($code, 'attribute_code');

	// gets our option values
	$option_col = Mage::getResourceModel( 'eav/entity_attribute_option_collection')
    ->setAttributeFilter($attribute2->getId()) 
    ->setStoreFilter();

	
	$data1 = $option_col->getData();
	$order = array();
	$i=0;
	foreach($data1 as $option){
		$order[$option['option_id']] =  $option['sort_order'];
	}
	
	$data["option"]=array("value" => $new_options);
	arsort($order);
	$data["order"]=$order;
 //var_dump($data);
 $b = array();
 $b = array(
   "attribute_id"=> "525",
   "is_global"=> "1",
   "default_value_text"=> "",
   "default_value_yesno"=> "0",
   "default_value_date"=> "" ,
   "default_value_textarea"=> "",
   "is_unique"=> "0" ,
   "is_required"=> "1" ,
   "frontend_class"=>  "" ,
   "apply_to"=> array(0=> "simple", 1=>"grouped" ,2=> "configurable" ),
   "is_configurable"=>  "1" ,
   "is_searchable"=> "1", 
   "is_visible_in_advanced_search"=> "0" ,
   "is_comparable"=> "0" ,
   "is_filterable"=> "0" ,
   "is_filterable_in_search"=> "0" ,
   "is_used_for_promo_rules"=> "1" ,
   "is_html_allowed_on_front"=> "0" ,
   "is_visible_on_front"=> "0" ,
   "used_in_product_listing"=> "0" ,
   "used_for_sort_by"=> "0" ,
   "frontend_label"=> array( 0=> "Shirt Size", 1=> "", 3=> "", 2=> "") ,
   "option"=> array("value"=> array(100=> array( 0=> "XSSSSS", 1=>  "", 3=> "", 2=> "") ,
   										99=> array(0=> "Medium", 1=> "", 3=> "", 2=> ""),
   										98=> array(0=> "Large", 1=>  "", 3=>"", 2=> "") )),
   	"order"=> array(100=> "0" ,99=> "1" ,98=> "2"),
   	"delete"=> array(100=> "", 99=> "", 98=> "" ) );
   	
   	var_dump("LLL");
   	var_dump($b);
	$attribute->addData($b);
	$attribute->save();*/
	
	//$option_col->addData($data);
	//$option_col->save();
     //$this->loadLayout(array('default'));
     //$this->renderLayout();
     /*$params = $this->getRequest()->getParams();
     //echo "setup";
     $hello = Mage::getModel('hello/questions');
     //echo get_class($hello);
     echo("Loading the blogpost with an ID of ".$params['id']);
    $hello->load($params['id']);     
    $data = $hello->getData();
    var_dump($data);    
    }
    
    public function createNewPostAction() {
    $blogpost = Mage::getModel('hello/questions');
    $blogpost->setQuestionsName('Code Post!');
    $blogpost->setQuestionsDescription('This post was created from code!');
    $blogpost->save();
    echo 'post created';*/
}
}