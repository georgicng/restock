<?php

class Gaiproject_Restock_Model_Observer
{ 
    public function catalog_product_save_before($observer)
    {
        $product = $observer->getProduct();
        Mage::log($product->getName(), null, 'restock.log');
        if($product->getTypeId() == "restockable"){
            if ($product->hasOptions()) {
                foreach ($product->getOptions() as $option) {
                    if ($option->getTitle() === 'Schedule') {                        
                        Mage::log('Schedule found for '.$product->getName(), null, 'restock.log');
                        return;
                    }
                }
            }

            $option = array(
                'title' => 'Schedule',
                'type' => 'cron',
                'is_require' => 0,
                'price' => 0,
                'price_type' => 'fixed',
                'sku' => ''
            );
            $product->setHasOptions(1);
            $optionInstance = $product->getOptionInstance()->unsetOptions();
            $optionInstance->addOption($option);
            $optionInstance->setProduct($product);
            Mage::log('Schedule saved for '.$product->getName(), null, 'restock.log');
        } 
    }
 
}