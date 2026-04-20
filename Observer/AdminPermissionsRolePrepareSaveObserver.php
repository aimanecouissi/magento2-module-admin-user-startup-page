<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Observer;

use AimaneCouissi\AdminUserStartupPage\Model\Config;
use Magento\Authorization\Model\Role;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AdminPermissionsRolePrepareSaveObserver implements ObserverInterface
{
    /**
     * @param RequestInterface $request
     */
    public function __construct(private readonly RequestInterface $request)
    {
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer): void
    {
        /** @var Role|null $role */
        $role = $observer->getEvent()->getData('object');
        if ($role === null) {
            return;
        }
        $menuItemId = $this->request->getParam(Config::STARTUP_MENU_ITEM_ID);
        $role->setData(Config::STARTUP_MENU_ITEM_ID, $menuItemId);
    }
}
