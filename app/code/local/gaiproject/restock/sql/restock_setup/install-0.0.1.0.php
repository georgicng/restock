<?php
$installer = $this;
 
$installer->startSetup();
 
$catalogInstaller = new Mage_Catalog_Model_Resource_Setup($this_resourceName);

$additionalTable =  $catalogInstaller->getEntityType('catalog_product', 'additional_attribute_table');

$this->run("
    UPDATE `{$this->getTable($additionalTable)}`
        SET apply_to = CONCAT_WS(',', apply_to, 'restockable')
        WHERE apply_to LIKE '%simple%' AND apply_to NOT LIKE '%restockable%'
    ;
");

$installer->endSetup();
