<?php

class Gaiproject_Restock_Model_Resource_Schedule_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract{
    protected function _construct()
    {
        $this->_init('restock/schedule');
    }
}