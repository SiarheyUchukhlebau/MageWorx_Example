<?php

namespace MageWorx\Example\Model;

use Magento\Catalog\Model\Product\Option;
use Magento\Catalog\Api\Data\ProductExtensionFactory;


class ProductOptionRepository implements \MageWorx\Example\Api\ProductCustomOptionRepositoryInterface
{
    /**
     * @var ProductExtensionFactory
     */
    private $productExtensionFactory;

    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Option
     */
    protected $optionEntity;

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param Option $optionEntity
     * @param ProductExtensionFactory $productExtensionFactory
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        Option $optionEntity,
        ProductExtensionFactory $productExtensionFactory
    ) {
        $this->productRepository       = $productRepository;
        $this->optionEntity            = $optionEntity;
        $this->productExtensionFactory = $productExtensionFactory;
    }

    /**
     * @inheritdoc
     */
    public function getList(string $sku): array
    {
        $product = $this->productRepository->get($sku, true);
        $options = $product->getOptions();

        foreach ($options as $optionIndex => $option) {
            $extensionAttributes = $option->getExtensionAttributes();
            if (empty($extensionAttributes)) {
                $extensionAttributes = $this->productExtensionFactory->create();
            }
            $mageworxTitle = $option->getMageworxTitle();
            $extensionAttributes->setMageworxTitle(['Title 1', 'Title 2', 'Title 939']);
            $option->setExtensionAttributes($extensionAttributes);
        }

        return $options ?: [];
    }
}
