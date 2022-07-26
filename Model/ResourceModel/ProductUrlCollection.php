<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\Example\Model\ResourceModel;

use Magento\CatalogUrlRewrite\Model\ProductUrlRewriteGenerator;
use Magento\Framework\App\ResourceConnection;
use Magento\Store\Model\StoreManagerInterface;

class ProductUrlCollection
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * ProductPathCollection constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        ResourceConnection $resourceConnection
    ) {
        $this->storeManager       = $storeManager;
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @param $productSkus
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductUrlCollection($productSkus)
    {
        $baseUrl    = $this->storeManager->getStore()->getBaseUrl();
        $connection = $this->resourceConnection->getConnection();

        $selectProductPath = $connection->select()->from(
            ['e' => $this->resourceConnection->getTableName('catalog_product_entity')],
            ['sku']
        )->joinLeft(
            ['url_rewrite' => $this->resourceConnection->getTableName('url_rewrite')],
            'e.entity_id = url_rewrite.entity_id AND url_rewrite.metadata IS NULL'
            . $connection->quoteInto(' AND url_rewrite.entity_type = ?', ProductUrlRewriteGenerator::ENTITY_TYPE),
            ['url' => 'request_path']
        )->where("e.sku IN (" . implode(',', $productSkus) . ")");

        $data = $connection->fetchAll($selectProductPath);

        $result = [];
        foreach ($data as $row) {
            $result[$row['sku']] = $baseUrl . $row['url'];
        }

        return $result;
    }
}
