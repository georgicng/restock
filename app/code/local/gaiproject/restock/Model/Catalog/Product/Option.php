<?php

class Gaiproject_Restock_Model_Catalog_Product_Option extends Mage_Catalog_Model_Product_Option
{
    const OPTION_GROUP_CRON       = 'cron';
    const OPTION_TYPE_CRON_TYPE   = 'cron';
    /**
     * Get group name of option by given option type
     *
     * @param string $type
     * @return string
     */
    public function getGroupByType($type = null)
    {
        if (is_null($type)) {
            $type = $this->getType();
        }

        $group = parent::getGroupByType($type);
        if( $group === '' && $type = self::OPTION_TYPE_CRON_TYPE ){
            $group = self::OPTION_GROUP_CRON;
        }
        return $group;
    }
    /**
     * Group model factory
     *
     * @param string $type Option type
     * @return Mage_Catalog_Model_Product_Option_Group_Abstract
     */
    public function groupFactory($type)
    {
        if( $type === self::OPTION_TYPE_CRON_TYPE ){
            return Mage::getModel('restock/catalog_product_option_type_crontype');
        }
        return parent::groupFactory($type);
    }
}