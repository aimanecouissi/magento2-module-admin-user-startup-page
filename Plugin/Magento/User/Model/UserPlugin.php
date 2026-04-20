<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Plugin\Magento\User\Model;

use AimaneCouissi\AdminUserStartupPage\Model\Config;
use AimaneCouissi\AdminUserStartupPage\Model\Filter\MenuItemId;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\App\ResourceConnection;
use Magento\User\Model\User;

class UserPlugin
{
    /**
     * @param RequestInterface $request
     * @param ResourceConnection $resourceConnection
     * @param MenuItemId $menuItemId
     */
    public function __construct(
        private readonly RequestInterface   $request,
        private readonly ResourceConnection $resourceConnection,
        private readonly MenuItemId         $menuItemId,
    )
    {
    }

    /**
     * Normalizes startup menu item ID before user persistence.
     *
     * @param User $subject
     * @return array|null
     */
    public function beforeBeforeSave(User $subject): ?array
    {
        $menuItemId = $this->menuItemId->filter($subject->getData(Config::STARTUP_MENU_ITEM_ID));
        $subject->setData(Config::STARTUP_MENU_ITEM_ID, $menuItemId);
        return null;
    }

    /**
     * Persists startup menu item ID after account self-save in admin.
     *
     * @param User $subject
     * @param User $result
     * @return User
     */
    public function afterAfterSave(User $subject, User $result): User
    {
        if (!$this->request instanceof HttpRequest) {
            return $result;
        }
        if ($this->request->getFullActionName() !== 'adminhtml_system_account_save') {
            return $result;
        }
        $connection = $this->resourceConnection->getConnection();
        $menuItemId = $this->menuItemId->filter($this->request->getParam(Config::STARTUP_MENU_ITEM_ID));
        $connection->update(
            $this->resourceConnection->getTableName('admin_user'),
            [Config::STARTUP_MENU_ITEM_ID => $menuItemId],
            ['user_id = ?' => (int)$subject->getId()]
        );
        return $result;
    }
}
