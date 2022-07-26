<?php

namespace MageWorx\Example\Block;

class CategoryAdditional extends \Magento\Framework\View\Element\Template
{
    public function getCollection() {
        return $this->getLayout()->getBlock('category.products.list')->getLoadedProductCollection();
    }
}
