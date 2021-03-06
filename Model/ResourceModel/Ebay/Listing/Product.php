<?php

/*
 * @author     M2E Pro Developers Team
 * @copyright  M2E LTD
 * @license    Commercial use is forbidden
 */

namespace Ess\M2ePro\Model\ResourceModel\Ebay\Listing;

/**
 * Class \Ess\M2ePro\Model\ResourceModel\Ebay\Listing\Product
 */
class Product extends \Ess\M2ePro\Model\ResourceModel\ActiveRecord\Component\Child\AbstractModel
{
    protected $_isPkAutoIncrement = false;

    //########################################

    public function _construct()
    {
        $this->_init('m2epro_ebay_listing_product', 'listing_product_id');
        $this->_isPkAutoIncrement = false;
    }

    //########################################

    public function getTemplateCategoryIds(array $listingProductIds, $columnName, $returnNull = false)
    {
        $select = $this->getConnection()
            ->select()
            ->from(['elp' => $this->getMainTable()])
            ->reset(\Zend_Db_Select::COLUMNS)
            ->columns([$columnName])
            ->where('listing_product_id IN (?)', $listingProductIds);

        !$returnNull && $select->where("{$columnName} IS NOT NULL");

        foreach ($select->query()->fetchAll() as $row) {
            $id = $row[$columnName] !== null ? (int)$row[$columnName] : null;
            if (!$returnNull) {
                continue;
            }

            $ids[$id] = $id;
        }

        return array_values($ids);
    }

    //########################################

    public function assignTemplatesToProducts(
        $productsIds,
        $categoryTemplateId = null,
        $categorySecondaryTemplateId = null,
        $storeCategoryTemplateId = null,
        $storeCategorySecondaryTemplateId = null
    ) {
        if (empty($productsIds)) {
            return;
        }

        $bind = [
            'template_category_id'                 => $categoryTemplateId,
            'template_category_secondary_id'       => $categorySecondaryTemplateId,
            'template_store_category_id'           => $storeCategoryTemplateId,
            'template_store_category_secondary_id' => $storeCategorySecondaryTemplateId
        ];
        $bind = array_filter($bind);

        $this->getConnection()->update(
            $this->getMainTable(),
            $bind,
            ['listing_product_id IN (?)' => $productsIds]
        );
    }

    //########################################
}
