<?php

class Gaiproject_Restock_Block_Adminhtml_Catalog_Product_Edit_Tab_Options_Type_Cron extends
    Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options_Type_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('restock/catalog/product/edit/options/type/cron.phtml');
    }
}