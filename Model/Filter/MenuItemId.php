<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Model\Filter;

use Laminas\Filter\StringTrim;
use Laminas\Filter\ToNull;

class MenuItemId
{
    /**
     * @param StringTrim $stringTrim
     * @param ToNull $toNull
     */
    public function __construct(
        private readonly StringTrim $stringTrim,
        private readonly ToNull     $toNull,
    )
    {
    }

    /**
     * Filters menu item ID into a trimmed nullable string value.
     *
     * @param mixed $menuItemId
     * @return string|null
     */
    public function filter(mixed $menuItemId): ?string
    {
        if (!is_string($menuItemId)) {
            return null;
        }
        $menuItemId = $this->stringTrim->filter($menuItemId);
        $menuItemId = $this->toNull->filter($menuItemId);
        return is_string($menuItemId) ? $menuItemId : null;
    }
}
