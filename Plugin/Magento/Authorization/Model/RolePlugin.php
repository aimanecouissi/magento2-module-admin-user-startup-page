<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Plugin\Magento\Authorization\Model;

use AimaneCouissi\AdminUserStartupPage\Model\Config;
use AimaneCouissi\AdminUserStartupPage\Model\Filter\MenuItemId;
use Magento\Authorization\Model\Role;

class RolePlugin
{
    /**
     * @param MenuItemId $menuItemId
     */
    public function __construct(private readonly MenuItemId $menuItemId)
    {
    }

    /**
     * Normalizes startup menu item ID before role persistence.
     *
     * @param Role $subject
     * @return array|null
     */
    public function beforeBeforeSave(Role $subject): ?array
    {
        $menuItemId = $this->menuItemId->filter($subject->getData(Config::STARTUP_MENU_ITEM_ID));
        $subject->setData(Config::STARTUP_MENU_ITEM_ID, $menuItemId);
        return null;
    }
}
