<?php

namespace MageWorx\Example\Api;

interface ProductCustomOptionRepositoryInterface
{
    /**
     * Get the list of custom options for a specific product
     *
     * @param string $sku
     * @return \Magento\Catalog\Api\Data\ProductCustomOptionInterface[]
     */
    public function getList(string $sku): array;

}
