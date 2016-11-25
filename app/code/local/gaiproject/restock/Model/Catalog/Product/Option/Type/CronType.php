<?php
class Gaiproject_Restock_Model_Catalog_Product_Option_Type_CronType
    extends Mage_Catalog_Model_Product_Option_Type_Default
{
    public function isCustomizedView()
    {
        return true;
    }

    public function getCustomizedView($optionInfo)
    {
        $customizeBlock = new Gaiproject_Restock_Block_Options_Type_Customview_Cron();
        $customizeBlock->setInfo($optionInfo);
        return $customizeBlock->toHtml();
    }
}