<?php

class Gaiproject_Restock_Model_Resource_Item extends Mage_Core_Model_Resource_Db_Abstract{
    protected function _construct()
    {
        $this->_init('restock/item', 'item_id');
    }
}