<?php 

class Gaiproject_Restock_Model_Item extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('restock/item');
    }
}