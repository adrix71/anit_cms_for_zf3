At night and in transportation - CMS
====================================

Introduction
------------
 
Welcome to the repository of "Anit - CMS".
In 2013 I decide to learn Zend Framework 2.
In order to learn the basics of this framework, I have the project to develop my own cms.
At the beginning, It was really basic but step by step I've added more features.
Finally I share my work because I think it is not a prototype anymore but people or company can use it as a cms.
I add more features step by step in order to fit most demanding needs for building a web site. 
The cms runs on Zend Framework 3. 


Principles of the cms
---------------------

Intro
-----
I worked for many companies in order to develop their own back-office for their web sites.
But unfortunately they did not designed their back-office to have common modules or components able to be used for their other web sites or web application. 
So I decided to design a solution in order to create customizable web sites easily.

Benefits
--------
Modularity and Scalability:
Thanks to ZF3, on the back-end side, you can easily add features through zend modules or through your own php library.
On the front-end side, you have to think your web page as blocks, blocks that have their own blocks.
By this way you can stay focused on the UI.

Maintainability :
You know what's going on. You have the control of the code.
It is easily maintainable because it applies the MVC pattern flavour from Zend Framework.
I offer a simple way to organize your cms with zend.

Native features :
You have by default features like :
Access Control List
Files Management
Blog
Extranet
...


Principles
----------
Let's talk about the principles of the cms :
- Page (Module : Rubrique): it's a web page, the main container.

- Section (Module : Sous-Rubrique) : a page has one or many sections. 
a section does not represent a section tag in html, it represents a piece of your page.

- Content (Module : Contenu, Galerie, Blogcontent) : a section has one or many contents.
I have divided content in three types :
    - stdContent : html content that you can edit with an editor + title and subtitle
    - imgContent : std content plus images
    - blogContet : imgContent plus another fields like author, date...
It's up to you to create a new one or just modify an existing one.

- Message (Module : Message) : It's a message sent by visitors through a form

- Comment (Module : Commentaire) : It's a comment sent to a content

By default messages and comments are stored in the database.
You can also send it by email. The code have been commented in the modules.
You just have to uncomment and put values in the related configuration files (folder EmailConfig in a module)
The email sending is done by smtp client but you have also the option to send emails from visitor through sendmail.
You just have to comment smtp client code and uncomment sendmail code inside the controller.

- Files (Module : Fichiers) : All the files or images included in your content are managed by this module.
If you want to add or update files of a content, you will find all the files and their link in a table
in the management page (add or update page) of your content.
In your content you will put the link of the file. You will find example.

- Loginmgmt (Module : Loginmgmt) : You can manage back office users.
You have by default three roles : 
    - anonymous is the default role associated to a visitor of your public web site or blog
    - user has access to the back-office except loginmgmt
    - administrator has access to the back-office and to the login management module

- MyAcl (Module : MyAcl) : In this module you can manage role and url allowed by role.
The role is stored in a session (configuration is in the Application module)

- Pagearrangement (Module : Pagearrangement) : It allows to see the hierarchy of the elements (sections, contents) of a page.
You can change the position of sections and contents.
By clicking on a button you can go to the form that you allow to update the selected element.
It is very useful to have an overview of your page
That's the object sent by the controller to the view.

- Links (Module Linktocontenu) : It allows to create a link of a content into another page.
In fact it's more than a link, you can customize the appearance of your link by adding an image, html, title... 
For example, you want to create a shortcut to an article of your blog in your index page, you can easily customize the link in order to fit the design of your page.

- Privatespace : It allows to declare an extranet in addition to your public web site.

- Privatespacelogin : It allows to manage users of the extranet you have created.

- Siteprivate : 
    It allows to :
        - manage the display of the pages related to a private space (Extranet).
        - manage the subscription of a new user 
        - manage the case of a user who forgot his password.
        - manage comment's form 
        - manage contact's form

- Sitepublic :
    It allows to :
        - manage the display of the pages related to your public web site.
        - manage comment's form
        - manage contact's form
 
- Pagews :  It contains web services. It gives you pagearrangement object related to a page (public or private)


Position
--------
In order to build your web site properly, you must give a position to your page, sections and contents.
The first page called if you don't provide id or pagename will be the page with the smaller rank.
If you want to prepare a section or content but you don't want to show it, you just have to put a number below 0.


Layout
------
You can use different layout for the web site. I use EdpModuleLayouts from Evan Coury.
It's easy to configure, you can configure it in the module.config.php of the application module.
You already have the code in module.config.php.


Database
--------
You need to execute the sql script in order to create the database.
It is located in data/database folder.
The connection settings is located in the module/Application/src/Application/DBconnection.
If you need to connect to another databases, you can add your own class or simply add method in the existing class.
All Dao classes extends Parentdao class that instantiate connection to the database. 
I use pdo driver for Mysql.


Third Party Library
------------------
You want to use a third party library or your own php library and call it in your project. 
You have to put the library in a folder inside the vendor folder.
You declare your library in composer.json file. In order to validate your changes, launch composer update.
 
 
Internationalization
--------------------
The default language enabled is the english language.
Now I must confess I have developed in french. So the native language is french and strings are translated in english.
In fact, I didn't think I will share this project. 
It explains why you have modules name with french words.
For the ui of the back-office, if you want to translate to another language, you have to create
and edit a new po file with a po editor.
The method to translate a string is ... translate('string'). If you want to add a translate method outside views and controllers, you need to use the method translate in ExtLib located in the vendor folder.
You also have to download the js file that contains the translation of tiny mce in your language.
http://www.tinymce.com/i18n/


Cache
-----
Data related to the files bank of your project is stored in a file cache.
If you add, update or delete a file, the cache is flushed and it has been re-created.
The cache strategy used in this cms don't need to enable or import a php module.
In production mode you can uncomment configuration cache located in application.config.php
Do not forget to set write permission on data/cache folder and its subfolders
You have another cache methods supported by zend(apc, memcached, redis...), it's up to you to add another cache strategy.
http://framework.zend.com/manual/current/en/modules/zend.cache.storage.adapter.html
The configuration is located in the module.config.php in the application module.


Zend Framework
--------------------
You don't need to know zend framework to use the cms but if you want to customize the behaviour of the
the back-office or add new features it could be a good idea to have knowledges of the framework.
All the code and configuration can be customized to fit your needs. 

I have a lot of ideas to improve and optimize this project.
If yout want to contribute, you are welcome.


Installation
------------
- git (https://git-scm.com/):
You can clone the project :
git clone https://rongeb@bitbucket.org/rongeb/anit-cms-for-zend-framework-3.git

dependencies :
The project is build on top of zend framework 3. It works with php >= 5.6.
If you want to use a newer version of zend framework, you have to use composer.
You have to modify the composer.json file and remove composer.lock files
With the command line, you go to the root folder of the project and you type :
php composer.phar install
More information on composer:
https://getcomposer.org/download/

- Github :
You can find the the clone project here :
https://github.com/rongeb/anit_cms_for_zf3.git

- Composer :
composer require atnightandintransportation/cms 
or
php composer.phar require atnightandintransportation/cms

- Login to connect to the back-office :
user : anit_admin
password : anit_admin

- Login to connect to the extranet :
user : anit_private@anit.org
password : anit_private@anit.org

- Requirement
MySql 5 or above
php >= 5.6 for zend framework 3

