Module RBAC provides a web interface for advanced access control and includes following features:

- Allows CRUD operations for roles, permissions, rules
- Allows to assign multiple roles or permissions to the user
- Allows to create console migrations

[![Latest Stable Version](https://poser.pugx.org/panix/mod-projects-calc/v/stable)](https://packagist.org/packages/panix/mod-projects-calc)
[![Latest Unstable Version](https://poser.pugx.org/panix/mod-projects-calc/v/unstable)](https://packagist.org/packages/panix/mod-projects-calc)
[![Total Downloads](https://poser.pugx.org/panix/mod-projects-calc/downloads)](https://packagist.org/packages/panix/mod-projects-calc)
[![Monthly Downloads](https://poser.pugx.org/panix/mod-projects-calc/d/monthly)](https://packagist.org/packages/panix/mod-projects-calc)
[![Daily Downloads](https://poser.pugx.org/panix/mod-projects-calc/d/daily)](https://packagist.org/packages/panix/mod-projects-calc)
[![License](https://poser.pugx.org/panix/mod-projects-calc/license)](https://packagist.org/packages/panix/mod-projects-calc)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer require --prefer-dist panix/mod-projects-calc "*"
```

or add

```
"panix/mod-projects-calc": "*"
```

to the require section of your `composer.json` file.

#### Add to web config.
```php
return [
    'modules' => [
        'projectscalc' => [
            'class' => 'panix\mod\projectscalc\Module',
        ],
    ],
];
```

#### Migrate
```bash
php yii migrate --migrationPath=vendor/panix/mod-shop/migrations
```
