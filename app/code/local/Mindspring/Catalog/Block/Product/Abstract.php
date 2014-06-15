<?php
class Mindspring_Catalog_Block_Product_Abstract extends Mage_Catalog_Block_Product_Abstract
{
	protected $_questionsHelperBlock;
	public function getQuestionsSummaryHtml(Mage_Catalog_Model_Product $product, $templateType = false, $displayIfNoReviews = false)
    {
        $this->_initQuestionsHelperBlock();
        return $this->_questionsHelperBlock->getSummaryHtml($product, $templateType, $displayIfNoReviews);
    }
}