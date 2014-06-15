<?php
class Mindspring_Questions_QuestionsController extends Mage_Core_Controller_Front_Action
{
	protected $_cookieCheckActions = array('post');
	
	public function preDispatch()
    {
        parent::preDispatch();

        $allowGuest = Mage::helper('questions')->getIsGuestAllowToWrite();
        if (!$this->getRequest()->isDispatched()) {
            return;
        }

        $action = $this->getRequest()->getActionName();
        if (!$allowGuest && $action == 'post' && $this->getRequest()->isPost()) {
            if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
                $this->setFlag('', self::FLAG_NO_DISPATCH, true);
                Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::getUrl('*/*/*', array('_current' => true)));
                Mage::getSingleton('questions/session')->setFormData($this->getRequest()->getPost())
                    ->setRedirectUrl($this->_getRefererUrl());
                $this->_redirectUrl(Mage::helper('customer')->getLoginUrl());
            }
        }

        return $this;
    }
    
	public function viewAction()
    {
        $questions = $this->_loadQuestions((int) $this->getRequest()->getParam('id'));
        if (!$questions) {
            $this->_forward('noroute');
            return;
        }

        $product = $this->_loadProduct($questions->getEntityPkValue());
        if (!$product) {
            $this->_forward('noroute');
            return;
        }

        $this->loadLayout();
        $this->_initLayoutMessages('questions/session');
        $this->_initLayoutMessages('catalog/session');
        $this->renderLayout();
    }
    
	public function listAction()
    {
        if ($product = $this->_initProduct()) {
            Mage::register('productId', $product->getId());

            $design = Mage::getSingleton('catalog/design');
            $settings = $design->getDesignSettings($product);
            if ($settings->getCustomDesign()) {
                $design->applyCustomDesign($settings->getCustomDesign());
            }
            $this->_initProductLayout($product);

            // update breadcrumbs
            if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
                $breadcrumbsBlock->addCrumb('product', array(
                    'label'    => $product->getName(),
                    'link'     => $product->getProductUrl(),
                    'readonly' => true,
                ));
                $breadcrumbsBlock->addCrumb('questions', array('label' => Mage::helper('questions')->__('Product Reviews')));
            }

            $this->renderLayout();
        } elseif (!$this->getResponse()->isRedirect()) {
            $this->_forward('noRoute');
        }
    }
    
	protected function _initProduct()
    {
        Mage::dispatchEvent('questions_controller_product_init_before', array('controller_action'=>$this));
        $categoryId = (int) $this->getRequest()->getParam('category', false);
        $productId  = (int) $this->getRequest()->getParam('id');

        $product = $this->_loadProduct($productId);

        if ($categoryId) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            Mage::register('current_category', $category);
        }

        try {
            Mage::dispatchEvent('questions_controller_product_init', array('product'=>$product));
            Mage::dispatchEvent('questions_controller_product_init_after', array('product'=>$product, 'controller_action' => $this));
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            return false;
        }

        return $product;
    }
    
	protected function _loadProduct($productId)
    {
        if (!$productId) {
            return false;
        }

        $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($productId);
        /* @var $product Mage_Catalog_Model_Product */
        if (!$product->getId() || !$product->isVisibleInCatalog() || !$product->isVisibleInSiteVisibility()) {
            return false;
        }

        Mage::register('current_product', $product);
        Mage::register('product', $product);

        return $product;
    }
    
	protected function _initProductLayout($product)
    {
        $update = $this->getLayout()->getUpdate();

        $update->addHandle('default');
        $this->addActionLayoutHandles();


        $update->addHandle('PRODUCT_TYPE_'.$product->getTypeId());

        if ($product->getPageLayout()) {
            $this->getLayout()->helper('page/layout')
                ->applyHandle($product->getPageLayout());
        }

        $this->loadLayoutUpdates();
        if ($product->getPageLayout()) {
            $this->getLayout()->helper('page/layout')
                ->applyTemplate($product->getPageLayout());
        }
        $update->addUpdate($product->getCustomLayoutUpdate());
        $this->generateLayoutXml()->generateLayoutBlocks();
    }
    
	public function postAction()
    {
        if ($data = Mage::getSingleton('questions/session')->getFormData(true)) {
            $rating = array();
            /*if (isset($data['ratings']) && is_array($data['ratings'])) {
                $rating = $data['ratings'];
            }*/
        } else {
            $data   = $this->getRequest()->getPost();
            //$rating = $this->getRequest()->getParam('ratings', array());
        }

        if (($product = $this->_initProduct()) && !empty($data)) {
            $session    = Mage::getSingleton('core/session');
            /* @var $session Mage_Core_Model_Session */
            $questions     = Mage::getModel('questions/questions')->setData($data);
            /* @var $review Mage_Review_Model_Review */

            $validate = $questions->validate();
            if ($validate === true) {
                try {
                    $questions->setEntityId($questions->getEntityIdByCode(Mindspring_Questions_Model_Questions::ENTITY_PRODUCT_CODE))
                        ->setEntityPkValue($product->getId())
                        ->setStatusId(Mindspring_Questions_Model_Questions::STATUS_PENDING)
                        ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                        ->setStoreId(Mage::app()->getStore()->getId())
                        ->setStores(array(Mage::app()->getStore()->getId()))
                        ->save();

                    foreach ($rating as $ratingId => $optionId) {
                        Mage::getModel('rating/rating')
                        ->setRatingId($ratingId)
                        ->setQuestionsId($questions->getId())
                        ->setCustomerId(Mage::getSingleton('customer/session')->getCustomerId())
                        ->addOptionVote($optionId, $product->getId());
                    }

                    $questions->aggregate();
                    $session->addSuccess($this->__('Your questions has been accepted for moderation.'));
                }
                catch (Exception $e) {
                    $session->setFormData($data);
                    $session->addError($this->__('Unable to post the questions.'));
                }
            }
            else {
                $session->setFormData($data);
                if (is_array($validate)) {
                    foreach ($validate as $errorMessage) {
                        $session->addError($errorMessage);
                    }
                }
                else {
                    $session->addError($this->__('Unable to post the questions.'));
                }
            }
        }

        if ($redirectUrl = Mage::getSingleton('questions/session')->getRedirectUrl(true)) {
            $this->_redirectUrl($redirectUrl);
            return;
        }
        $this->_redirectReferer();
    }
}