<?php
class Mindspring_Questions_Block_Product_View extends Mage_Catalog_Block_Product_View
{
	protected $_questionsHelperBlock;
	
	public function getQuestionsSummaryHtml(Mage_Catalog_Model_Product $product, $templateType = false, $displayIfNoReviews = false)
    {
        $this->_initQuestionsHelperBlock();
        return $this->_questionsHelperBlock->getSummaryHtml($product, $templateType, $displayIfNoReviews);
    }
    
	protected function _initQuestionsHelperBlock()
    {
        if (!$this->_questionsHelperBlock) {
            $this->_questionsHelperBlock = $this->getLayout()->createBlock('questions/helper');
        }
    }
    

}