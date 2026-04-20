<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Plugin\Magento\Backend\Model;

use AimaneCouissi\AdminUserStartupPage\Model\Config;
use AimaneCouissi\AdminUserStartupPage\Model\Filter\MenuItemId;
use Exception;
use Magento\Authorization\Model\Acl\Role\Group as RoleGroup;
use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Backend\Model\Menu\Config as MenuConfig;
use Magento\Backend\Model\Url;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\LocalizedException;
use Magento\User\Model\User;

class UrlPlugin
{
    /**
     * @param AuthSession $authSession
     * @param MenuConfig $menuConfig
     * @param ResourceConnection $resourceConnection
     * @param MenuItemId $menuItemId
     */
    public function __construct(
        private readonly AuthSession        $authSession,
        private readonly MenuConfig         $menuConfig,
        private readonly ResourceConnection $resourceConnection,
        private readonly MenuItemId         $menuItemId,
    )
    {
    }

    /**
     * Returns a configured startup page URL when user or role preference exists.
     *
     * @param Url $subject
     * @param string $result
     * @return string
     * @throws LocalizedException
     * @throws Exception
     */
    public function afterGetStartupPageUrl(Url $subject, string $result): string
    {
        $user = $this->authSession->getUser();
        if ($user === null) {
            return $result;
        }
        $menuItemId = $this->getMenuItemIdByUser($user);
        if ($menuItemId === null) {
            return $result;
        }
        $menuItem = $this->menuConfig->getMenu()->get($menuItemId);
        if ($menuItem === null || !$menuItem->isAllowed() || !$menuItem->getAction()) {
            return $result;
        }
        return $menuItem->getAction();
    }

    /**
     * Resolves startup menu item ID from user data with role fallback.
     *
     * @param User $user
     * @return string|null
     * @throws LocalizedException
     */
    private function getMenuItemIdByUser(User $user): ?string
    {
        $menuItemId = $this->menuItemId->filter($user->getData(Config::STARTUP_MENU_ITEM_ID));
        if ($menuItemId !== null) {
            return $menuItemId;
        }
        $roleIds = $user->getRoles();
        if ($roleIds === []) {
            return null;
        }
        $connection = $this->resourceConnection->getConnection();
        $select = $connection->select()
            ->from(
                $this->resourceConnection->getTableName('authorization_role'),
                [Config::STARTUP_MENU_ITEM_ID]
            )
            ->where('role_id IN (?)', $roleIds)
            ->where('role_type = ?', RoleGroup::ROLE_TYPE)
            ->where(sprintf('%s IS NOT NULL', Config::STARTUP_MENU_ITEM_ID))
            ->where(sprintf('%s <> ?', Config::STARTUP_MENU_ITEM_ID), '')
            ->order('role_id ASC')
            ->limit(1);
        return $this->menuItemId->filter($connection->fetchOne($select));
    }
}
