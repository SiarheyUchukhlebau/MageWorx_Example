<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace MageWorx\Example\Controller\Index;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Collection implements \Magento\Framework\App\ActionInterface
{
    /**
     * @var \Magento\Framework\Controller\ResultFactory
     */
    private $resultFactory;

    /**
     * @var \Magento\Store\Model\ResourceModel\Store\CollectionFactory
     */
    private $collectionFactory;

    /**
     * Index constructor.
     *
     * @param \Magento\Framework\Controller\ResultFactory $resultFactory
     */
    public function __construct(
        \Magento\Framework\Controller\ResultFactory $resultFactory,
        \Magento\Store\Model\ResourceModel\Store\CollectionFactory $collectionFactory
    ) {
        $this->resultFactory = $resultFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $result = $this->resultFactory->create(ResultFactory::TYPE_RAW);

        $collection = $this->collectionFactory->create();
        $collection->getItems();
        $data = $collection->toArray();

        $result->setContents(print_r($data, true));

        return $result;
    }
}
