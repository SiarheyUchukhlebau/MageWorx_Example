<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace MageWorx\Example\Block;

use Magento\Framework\View\Element\Template;

class CategorySubtotal extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $serializer;

    /**
     * @param Template\Context $context
     * @param array $data
     */
    public function __construct(
        Template\Context                             $context,
        \Magento\Framework\Serialize\Serializer\Json $serializer,
        array                                        $data = []
    ) {
        $this->serializer      = $serializer;
        parent::__construct($context, $data);
    }

    /**
     * Prepare and return JS layout
     *
     * @return string
     */
    public function getJsLayout(): string
    {
        $this->processJsLayout();

        return $this->serializer->serialize($this->jsLayout);
    }

    /**
     * Make layout modifications
     *
     * @return void
     */
    protected function processJsLayout(): void
    {

    }
}
