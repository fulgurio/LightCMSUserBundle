LightCMSUserBundle
========
This bundle for [LightCMS](https://github.com/fulgurio/LightCMSBundle) is the user manager bundle.

To use it, just follow these steps :

1. Install LightCMSBundle and configure it
2. Download this bundle
3. Enable the Bundle
4. Import routing
5. Configure your yml files
6. Add new user account


### Step 1: Install LightCMSBundle and configure it

Follow the [installation doc](https://github.com/fulgurio/LightCMSBundle/blob/master/Resources/docs/Installation.md) to install LightCMS.

### Step 2: Download this bundle

Add this line into your composer.json file

``` json
{
    "require": {
        "fulgurio/light-cms-user-bundle" : "dev-master"
    }
}
```

After, just launch composer, it will load all dependencies

``` bash
$ ./composer update
```

### Step 3: Enable the bundle

Finally, enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Fulgurio\LightCMSUserBundle\FulgurioLightCMSUserBundle(),
    );
}
```

### Step 4: Import routing file

You need to put the following line before FulgurioLightCMSBundle routing :

``` yaml
# app/config/routing.yml
FulgurioLightCMSUserBundle:
    resource: "@FulgurioLightCMSUserBundle/Resources/config/routing.yml"
    prefix:   /

```

### Step 5: Configure your yml files

You need to set on the anonymous access, and to limit admin access. Edit
config/security.yml file and put the following configuration :
``` yaml
security:
    encoders:
        Symfony\Component\Security\Core\User\UserInterface: plaintext
    providers:
        lightcms:
            entity:
                class: Fulgurio\LightCMSUserBundle\Entity\User
                property: username
    firewalls:
        lightcms_secured_area:
            form_login:
                provider:   lightcms
                login_path: /login
                check_path: /login_check
            logout:
                path:       /logout
                target:     /
            anonymous:      ~
    access_control:
        - { path: ^/admin/, roles: ROLE_ADMIN }
```

### Step 6: Add new user account

Now, you need to add your first user. To do that, there's a command with the
console :
``` bash
$ ./app/console user:add

user:add username password email [role]
```

Just type your login informations, like :
``` bash
./app/console user:add admin mypassword admin@foo.bar ROLE_ADMIN
```

Note: you need to use the role which is allowed to access to /admin, in this
document, it's ROLE_ADMIN. Actually, roles are unused, there's no difference
between ROLE_USER or ROLE_ADMIN.