<?php

class Custom_Hello_Model_Questions extends Mage_Core_Model_Abstract 
{
    protected function _construct()
    {
        $this->_init('hello/questions');
    }   
}