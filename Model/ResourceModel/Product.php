<?php

namespace MageSuite\NotificationDashboard\Model\ResourceModel;

class Product
{
    const CATALOG_PRODUCT_ENTITY_TYPE_ID = 4;
    const STATUS_ATTRIBUTE_CODE = 'status';

    protected \Magento\Framework\DB\Adapter\AdapterInterface $connection;

    protected \Magento\Framework\EntityManager\MetadataPool $metadataPool;

    public function __construct(
        \Magento\Framework\App\ResourceConnection $resourceConnection,
        \Magento\Framework\EntityManager\MetadataPool $metadataPool
    ) {
        $this->connection = $resourceConnection->getConnection();
        $this->metadataPool = $metadataPool;
    }

    public function getProductsWithoutImages($typeIds)
    {
        $select = $this->connection
            ->select()
            ->from(['cpe' => $this->connection->getTableName('catalog_product_entity')], ['cpe.sku', 'cpe.entity_id', 'cpe.type_id'])
            ->joinLeft(
                ['cpemgvte' => $this->connection->getTableName('catalog_product_entity_media_gallery_value_to_entity')],
                'cpe. ' . $this->getLinkField() . ' = cpemgvte.' . $this->getLinkField(),
                []
            )
            ->joinLeft(
                ['cpemg' => $this->connection->getTableName('catalog_product_entity_media_gallery')],
                'cpemgvte.value_id = cpemg.value_id',
                ['count' => 'count(cpemg.value)']
            )
            ->joinLeft(
                ['cpei' => $this->connection->getTableName('catalog_product_entity_int')],
                'cpe.' . $this->getLinkField() . ' = cpei.' . $this->getLinkField(),
                []
            )
            ->where('cpei.attribute_id = ?', $this->getAttributeIdByCode(self::STATUS_ATTRIBUTE_CODE))
            ->where('cpei.store_id = ?', \Magento\Store\Model\Store::DEFAULT_STORE_ID)
            ->where('cpei.value = ? = ?', \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED)
            ->group('cpe.entity_id')
            ->having('count = 0')
            ->order('cpe.type_id', \Magento\Framework\Api\SortOrder::SORT_ASC)
            ->order('cpe.sku', \Magento\Framework\Api\SortOrder::SORT_ASC);

        if (!empty($typeIds)) {
            $select->where('cpe.type_id IN (?)', $typeIds);
        }

        return $this->connection->fetchAll($select);
    }

    public function getAttributeIdByCode($attributeCode)
    {
        $select = $this->connection
            ->select()
            ->from(['eava' => $this->connection->getTableName('eav_attribute')], ['attribute_id'])
            ->where('entity_type_id = ?', self::CATALOG_PRODUCT_ENTITY_TYPE_ID)
            ->where('attribute_code = ?', $attributeCode);

        return $this->connection->fetchOne($select);
    }

    protected function getLinkField(): string
    {
        return $this->metadataPool->getMetadata(\Magento\Catalog\Api\Data\ProductInterface::class)->getLinkField();
    }
}
