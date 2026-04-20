<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Rewrite\Magento\User\Block\Role\Tab;

use AimaneCouissi\AdminUserStartupPage\Model\Config;
use AimaneCouissi\AdminUserStartupPage\Model\Form\StartupPage as StartupPageField;
use Magento\Backend\Block\Template\Context;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Registry;
use Magento\Ui\Component\Form\Element\Select;
use Magento\User\Block\Role\Tab\Info as MagentoInfo;

class Info extends MagentoInfo
{
    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param StartupPageField $startupPageField
     * @param array $data
     */
    public function __construct(
        Context                           $context,
        Registry                          $registry,
        FormFactory                       $formFactory,
        private readonly StartupPageField $startupPageField,
        array                             $data = [],
    )
    {
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * @inheritDoc
     */
    protected function _initForm(): void
    {
        parent::_initForm();
        $form = $this->getForm();
        $fieldset = $form->getElement('base_fieldset');
        $fieldset->addField(
            Config::STARTUP_MENU_ITEM_ID,
            Select::NAME,
            $this->startupPageField->getConfig()
        );
        $data = ['in_role_user_old' => $this->getOldUsers()];
        $role = $this->getData('role');
        if ($role !== null && is_array($role->getData())) {
            $data = array_merge($data, $role->getData());
        }
        $form->setValues($data);
        $this->setForm($form);
    }
}
