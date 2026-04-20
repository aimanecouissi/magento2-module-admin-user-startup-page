# AimaneCouissi_AdminUserStartupPage

[![Latest Stable Version](http://poser.pugx.org/aimanecouissi/module-admin-user-startup-page/v)](https://packagist.org/packages/aimanecouissi/module-admin-user-startup-page) [![Total Downloads](http://poser.pugx.org/aimanecouissi/module-admin-user-startup-page/downloads)](https://packagist.org/packages/aimanecouissi/module-admin-user-startup-page) [![Magento Version Require](https://img.shields.io/badge/magento-~2.4.0-E68718)](https://packagist.org/packages/aimanecouissi/module-admin-user-startup-page) [![License](http://poser.pugx.org/aimanecouissi/module-admin-user-startup-page/license)](https://packagist.org/packages/aimanecouissi/module-admin-user-startup-page) [![PHP Version Require](http://poser.pugx.org/aimanecouissi/module-admin-user-startup-page/require/php)](https://packagist.org/packages/aimanecouissi/module-admin-user-startup-page)

Adds a **Startup Page** dropdown to Admin user and role forms, allowing each user or role to define the page shown after login.

## Installation
```bash
composer require aimanecouissi/module-admin-user-startup-page
bin/magento module:enable AimaneCouissi_AdminUserStartupPage
bin/magento setup:upgrade
bin/magento cache:flush
```

## Usage

The **Startup Page** dropdown is available in three places: the user edit form under **Admin → System → Permissions → All Users**, the role info tab under **Admin → System → Permissions → User Roles**, and the account settings form accessible from the upper-right account menu. Select any Admin menu page from the dropdown to set it as the startup page after login.

The user-level setting takes priority over the role-level setting. If neither is configured, the startup page falls back to the value set in **Stores → Configuration → Advanced → Admin → Startup Page**.

## Uninstall
```bash
bin/magento module:disable AimaneCouissi_AdminUserStartupPage
composer remove aimanecouissi/module-admin-user-startup-page
bin/magento setup:upgrade
bin/magento cache:flush
```

## Changelog

See [CHANGELOG](CHANGELOG.md) for all recent changes.

## License

[MIT](LICENSE)
