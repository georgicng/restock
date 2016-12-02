<?php
//$installer = $this;
$installer = Mage::getResourceModel('sales/setup', 'sales_setup');
$installer->startSetup();
$installer->addAttribute("order", "restock_reorder", array("type"=>"int"));
$installer->addAttribute("quote", "restock_reorder", array("type"=>"int"));
$installer->addAttribute("order", "restock_order", array("type"=>"int"));
$installer->addAttribute("quote", "restock_order", array("type"=>"int"));
$installer->addAttribute("order", "restock_listId", array("type"=>"int"));
$installer->addAttribute("quote", "restock_listId", array("type"=>"int"));
$installer->endSetup();