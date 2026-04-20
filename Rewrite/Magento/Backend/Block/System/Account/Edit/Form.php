<?php
/**
 * Aimane Couissi - https://aimanecouissi.com
 * Copyright © Aimane Couissi 2026–present. All rights reserved.
 * Licensed under the MIT License. See LICENSE for details.
 */

declare(strict_types=1);

namespace AimaneCouissi\AdminUserStartupPage\Rewrite\Magento\Backend\Block\System\Account\Edit;

use AimaneCouissi\AdminUserStartupPage\Model\Config;
use AimaneCouissi\AdminUserStartupPage\Model\Form\StartupPage as StartupPageField;
use Magento\Backend\Block\System\Account\Edit\Form as MagentoForm;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Model\Auth\Session as AuthSession;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\Locale\ListsInterface;
use Magento\Framework\Locale\OptionInterface;
use Magento\Framework\Registry;
use Magento\Ui\Component\Form\Element\Select;
use Magento\User\Model\ResourceModel\User as UserResource;
use Magento\User\Model\UserFactory;

class Form extends MagentoForm
{
    /**
     * @param Context $context
     * @param Registry $registry
     * @param FormFactory $formFactory
     * @param UserFactory $userFactory
     * @param AuthSession $authSession
     * @param ListsInterface $localeLists
     * @param UserResource $userResource
     * @param StartupPageField $startupPageField
     * @param array $data
     * @param OptionInterface|null $deployedLocales
     */
    public function __construct(
        Context                           $context,
        Registry                          $registry,
        FormFactory                       $formFactory,
        UserFactory                       $userFactory,
        AuthSession                       $authSession,
        ListsInterface                    $localeLists,
        private readonly UserResource     $userResource,
        private readonly StartupPageField $startupPageField,
        array                             $data = [],
        ?OptionInterface                  $deployedLocales = null,
    )
    {
        parent::__construct(
            $context,
            $registry,
            $formFactory,
            $userFactory,
            $authSession,
            $localeLists,
            $data,
            $deployedLocales
        );
    }

    /**
     * @inheritDoc
     */
    protected function _prepareForm(): static
    {
        $form = parent::_prepareForm()->getForm();
        $fieldset = $form->getElement('base_fieldset');
        $user = $this->_userFactory->create();
        $this->userResource->load($user, (int)$this->_authSession->getUser()->getId());
        $data = $user->getData();
        unset(
            $data['password'],
            $data[self::IDENTITY_VERIFICATION_PASSWORD_FIELD],
            $data['password_confirmation']
        );
        $fieldset->addField(
            Config::STARTUP_MENU_ITEM_ID,
            Select::NAME,
            $this->startupPageField->getConfig()
        );
        $form->setValues($data);
        $this->setForm($form);
        return $this;
    }
}
