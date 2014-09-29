Configuration
==============

SnapCMS configurations contain arbitrary configuration options used by your application. They are a replacement for Yii2's "params" and 
are found in your `/common/config/snapcms/` or `/frontend/config/snapcms/` folders. 

Associative arrays should be nested into logical groupings for clarity. Here is an example of `general.php` included in the installation.

```php
return [
    'menus' => [
        'main_menu' => 'Main Menu',
        'footer' => 'Footer',
    ],
    'site' => [
        'default_menu' => 'main_menu',
        'homepage' => 1,
        'title' => 'SnapCMS',
        'tag_line' => 'A CMS for developers and users',
        'admin_email' => 'webmaster@example.com',
    ],
];
```

Configurations are accessed via the **Config** model's **getData()** method e.g. 

```php
$title =  \snapcms\models\Config::getData('general/site.title');
```

This command tells the system that you wish to access information in the `snapcms/general.php` file at the location `['site']['title']` in the array. It will look for this value in the following files (and in this order):

1. `/common/config/snapcms/general.php`
2. `/common/config/snapcms/general-local.php`
3. `/frontend/config/snapcms/general.php`
4. `/frontend/config/snapcms/general-local.php`

This gives you the flexibility to define configurations based on environment in the same way allowed by Yii2's advanced application template.

Database Overrides
------------------

If you wish to allow the end user to override certain configuration values, you can activate this on a per configuration basis. 
This is done in the file located at `/common/config/snapcms/_allow_db_override.php`. Here you can add the 
string representation of the configuration you wish to be available from the SnapCMS admin interface found at **Administration -> Settings**.

Example:

```php
return [
    'general/site.title',
    'general/site.tag_line',
    'general/site.homepage' => [
		//'class' => '\snapcms\models\Config',
        'rules' => [['integer']],
        'input' => [
            'method' => 'dropDownList',
            //The parameters in the order they appear in the method chosen above
            'params' => [
                [
                    1 => 'Homepage',
                    2 => 'Another Page',
                ],
            ]
        ],
    ],
    'email/email.from_name',
    'email/email.from_address' => [
        'rules' => [['email', 'skipOnEmpty' => false]],
    ],
];
```

By default the settings will render a textField input and validate the length at 255 characters.
You are able to define additional validation rules and change the type of input that will be displayed on the settings page.
Note that the rule arrays are the same as the standard Yii definitions but without the attributes array.

```php
[/*['birthdate'],*/ 'validateAge', 'params' => ['min' => '12'], 'skipOnEmpty' => false],
```