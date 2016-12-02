<?php

class Gaiproject_Restock_Model_Observer
{ 
    public function catalog_product_save_before($observer)
    {
        $product = $observer->getProduct();
        if($product->getTypeId() == "restockable"){
            $options = $product->getOptions();
            if ($options) {
                foreach ($options as $key => $option) {
                    if ($option['title'] === 'Schedule') { 
                        Mage::log("option schedule found for ".$product->getName(), null, 'restock.log');                    
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

    public function sales_order_place_after($observer){
        try {
            Mage::log("sales_order_place_after start", null, 'restock.log');             
            $quote = $observer->getOrder()->getQuote();
            $helper = Mage::helper( 'catalog/product_configuration' );
            if(!is_null($quote->getData("restock_order"))){
                $model = Mage::getModel('restock/schedule');
                $model->setCustomer($quote->getCustomerId());
                /*
                    TODO: change schedule to customer preference and/or billing option
                */
                $model->setCreatedAt(date('Y-m-d H:i:s'));
                $model->save();
                foreach($quote->getAllItems() as $item) {     
                    if(($product = $item->getProduct()) && $product->getTypeId() == 'restockable') {
                        $options = $helper->getCustomOptions($item);
                        foreach ($options as $option) 
                        {
                            if ($option["label"] == 'Schedule'  && $option['value']) 
                            {
                                
                                $itemModel = Mage::getModel('restock/item');
                                $itemModel->setList($model->getId());
                                $itemModel->setOrder($quote->getId());
                                $itemModel->setQty($item->getQty());
                                /*TODO: Add schedule detail to each item
                                */
                                $itemModel->setSchedule($option['value']);
                                $itemModel->setProduct($product->getId());
                                $itemModel->setBuyrequest(serialize($option));
                                /*TODO: implement item preference and shipping information
                                        per item
                                */
                                $itemModel->setCreatedTime(date('Y-m-d H:i:s'));
                                $itemModel->save(); 
                                break;
                            }
                            
                        }
                    }
                }
            
            }           
            //Mage::helper("comp/connection")->updatesaveorder($order_id,$order->getCustomerId());

        } catch (Exception $e) {
            Mage::log($e->getMessage(), null, 'restock.log');
        }
        Mage::log("sales_order_place_after end", null, 'restock.log');

    }

    public function isAllowGuest($observer){
        Mage::log("isAllowedGuest start", null, 'restock.log');                   
        $quote = $observer->getEvent()->getQuote();
        $result = $observer->getEvent()->getResult();
        if ($this->hasSchedule($quote)) 
        {
            Mage::log("Schedule found", null, 'restock.log');
            $result->setIsAllowed(false);
        }
        Mage::log("isAllowedGuest end", null, 'restock.log');
    }

    public function saveCustomData($observer) {
        Mage::log("saveCustomData start", null, 'restock.log');
        $event = $observer->getEvent();
        $order = $event->getOrder();
        $quote = $event->getQuote();
        if ($this->hasSchedule($quote)) {
            Mage::log("has schedule", null, 'restock.log');
            $quote->setData("restock_order", 1, true);
            $order->setData("restock_order", 1, true);
            Mage::log("order set as restock order", null, 'restock.log');
        }
        Mage::log("saveCustomData end", null, 'restock.log');
            
    }


    private function hasSchedule($quote){
        $helper = Mage::helper( 'catalog/product_configuration' );    
        foreach($quote->getAllItems() as $item) {  
            if(($product = $item->getProduct()) && $product->getTypeId() == 'restockable') {            
                $options = $helper->getCustomOptions($item);
                foreach ($options as $option) 
                {
                    if ($option['label'] == 'Schedule'  && $option['value']) 
                    {
                        return true;
                    }
                    
                }                
            }            
        }
        return false;
    }
 
}