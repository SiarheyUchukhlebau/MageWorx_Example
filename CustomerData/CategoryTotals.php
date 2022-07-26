<?php
/**
 * Copyright © MageWorx. All rights reserved.
 * See LICENSE.txt for license details.
 */
declare(strict_types=1);

namespace MageWorx\Example\CustomerData;

class CategoryTotals implements \Magento\Customer\CustomerData\SectionSourceInterface
{
    /**
     * @var \Magento\Checkout\Model\Session\Proxy
     */
    protected $checkoutSession;

    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    protected $pricingHelper;

    /**
     * @param \Magento\Checkout\Model\Session\Proxy $checkoutSession
     * @param \Magento\Framework\Pricing\Helper\Data $pricingHelper
     */
    public function __construct(
        \Magento\Checkout\Model\Session\Proxy  $checkoutSession,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->pricingHelper   = $pricingHelper;
    }

    /**
     * @inheritDoc
     */
    public function getSectionData()
    {
        return [
            'category_subtotal_test' => '0$',
            'category_subtotal' => $this->getSubtotal()
        ];
    }

    /**
     * @return string
     * @throws \Magento\Framework\Exception\LocalizedException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    protected function getSubtotal(): string
    {
        $subtotalFormatted = 'N/A';
        if ($this->checkoutSession) {
            $quote = $this->checkoutSession->getQuote();
            if ($quote) {
                $subtotalFormatted = $this->pricingHelper->currencyByStore(
                    $quote->getSubtotal(),
                    $quote->getStoreId(),
                    true,
                    true
                );
            }
        }

        return $subtotalFormatted;
    }
}
