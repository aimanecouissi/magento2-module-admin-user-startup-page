<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Rewrite\Magento\User\Block\User\Edit\Tab;

use AimaneCouissi\AdminUserStartupPage\Model\Config;
use AimaneCouissi\AdminUserStartupPage\Model\Form\StartupPage as StartupPageField;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Locale\ListsInterface;
use Magento\Framework\Locale\OptionInterface;
use Magento\Framework\Registry;
use Magento\Ui\Component\Form\Element\Select;
use Magento\User\Block\User\Edit\Tab\Main as MagentoMain;

class Main extends MagentoMain
{
    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param AuthSession $authSession
     * @param ListsInterface $localeLists
     * @param StartupPageField $startupPageField
     * @param array $data
     * @param OptionInterface|null $deployedLocales
     */
    public function __construct(
        Context                           $context,
        Registry                          $registry,
        FormFactory                       $formFactory,
        AuthSession                       $authSession,
        ListsInterface                    $localeLists,
        private readonly StartupPageField $startupPageField,
        array                             $data = [],
        ?OptionInterface                  $deployedLocales = null,
    )
    {
        parent::__construct($context, $registry, $formFactory, $authSession, $localeLists, $data, $deployedLocales);
    }

    /**
     * @inheritDoc
     */
    protected function _prepareForm(): static
    {
        $form = parent::_prepareForm()->getForm();
        $baseFieldset = $form->getElement('base_fieldset');
        $data = $this->_coreRegistry->registry('permissions_user')->getData();
        unset(
            $data['password'],
            $data[self::CURRENT_USER_PASSWORD_FIELD],
            $data['password_confirmation']
        );
        $baseFieldset->addField(
            Config::STARTUP_MENU_ITEM_ID,
            Select::NAME,
            $this->startupPageField->getConfig()
        );
        $form->setValues($data);
        $this->setForm($form);
        return $this;
    }
}
