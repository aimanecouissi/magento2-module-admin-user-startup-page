<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Model\Form;

use AimaneCouissi\AdminUserStartupPage\Model\Config;
use AimaneCouissi\AdminUserStartupPage\Model\Source\StartupPage as StartupPageSource;

class StartupPage
{
    /**
     * @param StartupPageSource $startupPageSource
     */
    public function __construct(private readonly StartupPageSource $startupPageSource)
    {
    }

    /**
     * Returns UI field configuration for the startup page selector.
     *
     * @return array<string, mixed>
     */
    public function getConfig(): array
    {
        return [
            'name' => Config::STARTUP_MENU_ITEM_ID,
            'label' => __('Startup Page'),
            'title' => __('Startup Page'),
            'values' => $this->startupPageSource->toOptionArray(),
        ];
    }
}
