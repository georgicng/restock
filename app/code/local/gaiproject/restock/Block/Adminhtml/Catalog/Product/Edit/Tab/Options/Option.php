<?php

class Gaiproject_Restock_Block_Adminhtml_Catalog_Product_Edit_Tab_Options_Option
        extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Options_Option
{
    /**
     * Class constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('restock/catalog/product/edit/options/option.phtml');
    }
    /**
     * Retrieve html templates for different types of product custom options
     *
     * @return string
     */
    public function getTemplatesHtml()
    {
        $canEditPrice = $this->getCanEditPrice();
        $canReadPrice = $this->getCanReadPrice();

        $this->getChild('cron_option_type')
            ->setCanReadPrice($canReadPrice)
            ->setCanEditPrice($canEditPrice);
        $templates = parent::getTemplatesHtml() . "\n" .
            $this->getChildHtml('cron_option_type');
        return $templates;    
    } 
}