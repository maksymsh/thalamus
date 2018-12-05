# Thalamus.io 
========================

Welcome to the Thalamus Standard Edition.

This document contains information on how to download, install, and start
using Thalamus. For a more detailed explanation, see the [Installation][1]
chapter of the Thalamus Documentation.

## 1) Installing thalamus.io
----------------------------------

When it comes to installing the Symfony Standard Edition, you have the
following options.


### 1.1) git pull from github //console command

### 1.2) Adjust the folder permissions:

    web\uploads - 777
    web/media/cache - 777
    app\cache - 777
    app\logs - 777

### 1.3) create a database  //mysql

### 1.4) adjust the timezone for php to Berlin-Time //php.ini

### 1.5) composer update
    \\ windows     //console command
 
    php composer.phar update  \\Linux and Mac OS   //console command 

### 1.6) configure app/config/parameters.yml

### 1.7) Create / Update the database
    php app/console doctrine:schema:update --force  //console command

### 1.8) install assets
    php app/console assets:install web  //console command
    
### 1.9) install cronjob to fetch the mails

*/5 * * * * php /home/thalamus.io/app/console post:parse

This will run the PHP script ..src/WWSC/ThalamusBundle/Command/ParsePostRunCommand.php every 5 minutes.


## 2) Coding-styles and documentation
----------------------------------

### 2.1) Phpmd:
    bin\phpmd src\WWSC\ThalamusBundle
    bin\phpmd src\WWSC\ThalamusBundle xml codesize --reportfile phpmd.xml

    php vendor/phpmd/phpmd/src/bin/phpmd src/WWSC/ThalamusBundle xml codesize --reportfile web/phpmd.xml

### 2.2) php documentator
    bin\phpdoc run -d C:\wamp\www\thalamus\src\  -t C:\wamp\www\thalamus\src\WWSC\ThalamusBundle\Resources\public\phpdocumentor\

    http://thalamus/bundles/wwscthalamus/phpdocumentor/index.html
    
    
## 3) Some commands & misc
----------------------------------

    php app/console cache:clear --env=prod  -clear cache
    
    php app/console generate:bundle --namespace=WWSC/ThalamusBundle --format=yml
    
    php app/console generate:doctrine:form WWSCThalamusBundle:Account create form
    
    php app/console doctrine:generate:entity --entity="WWSCThalamusBundle:Account"
    
    php app/console doctrine:generate:entities WWSCThalamusBundle:Account
    
    php app/console doctrine:schema:update --force
    
    php app/console doctrine:fixtures:load 
    
    composer update
    
    instal composer
    
    @ORM\PreUpdate
    
    curl -s http://getcomposer.org/installer | php
    php composer.phar install
    composer update 
    
    
## 4) Bundles
    
    Transtable
    StofDoctrineExtensionsBundle
    
    
    
    Sonata and Fos User Bundle:
    http://symfony2.ylly.fr/sonataadminbundle-fosuserbundle-have-a-good-base-project-jordscream/
    http://blog.dayo.fr/2012/12/symfony2-1-sonata-admin-sonata-user-fos-userbundle-en/
    
    php app/console sonata:easy-extends:generate SonataUserBundle
    
    
    create New Bundle with Sonata
    http://www.ens.ro/2012/07/13/symfony2-jobeet-day-12-the-admin-bundle/
    
    
    php app/console fos:user:create admin admin@example.com admin --super-admin
    
    Tine MCE Bundle
    https://github.com/stfalcon/TinymceBundle
    
    
    I18N:
    php app/console translation:extract ru --bundle=DevComTimeTrekingBundle --default-output-format=po
    
    get culture
    {{ app.request.get('_locale') }}

## 5) Email: dev.thalamus@gmail.com Pass: thalamus#
