<?php
class Mindspring_Questions_Block_Helper extends Mage_Core_Block_Template
{
    protected $_availableTemplates = array(
        'default' => 'mindspring/questions/summary.phtml',
    );
    
    public function getSummaryHtml($product, $templateType, $displayIfNoReviews)
    {
        // pick template among available
        if (empty($this->_availableTemplates[$templateType])) {
            $templateType = 'default';
        }
        $this->setTemplate($this->_availableTemplates[$templateType]);

        $this->setDisplayIfEmpty($displayIfNoReviews);

        /*if (!$product->getRatingSummary()) {
            Mage::getModel('review/review')
               ->getEntitySummary($product, Mage::app()->getStore()->getId());
        }*/
        $this->setProduct($product);

        return $this->toHtml();
    }
    
	public function addTemplate($type, $template)
    {
        $this->_availableTemplates[$type] = $template;
    }
    
	public function getQuestionsUrl()
    {
        return Mage::getUrl('questions/questions/list', array(
           'id'        => $this->getProduct()->getId(),
           'category'  => $this->getProduct()->getCategoryId()
        ));
    }

}