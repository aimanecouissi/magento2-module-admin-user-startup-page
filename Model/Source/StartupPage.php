<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Model\Source;

use Magento\Config\Model\Config\Source\Admin\Page as PageSource;
use Magento\Framework\Data\OptionSourceInterface;

class StartupPage implements OptionSourceInterface
{
    /**
     * @param PageSource $pageSource
     */
    public function __construct(private readonly PageSource $pageSource)
    {
    }

    /**
     * @inheritDoc
     */
    public function toOptionArray(): array
    {
        $options = $this->pageSource->toOptionArray();
        array_unshift($options, [
            'label' => __('Use Default')->render(),
            'value' => '',
        ]);
        return $options;
    }
}
