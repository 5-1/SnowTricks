Snowtricks
========================

Welcome to snowtricks!
on App that uses Symfony 3.4

What's inside?
--------------

This project is linked to Openclassrooms DA PHP Symfony studies.
It's the 6th projets in which it is asked to create a community website called 
Snowtricks.

Require
--------------

PHP 7 / MySQL / Apache.
More easy if you download mamp/wamp/XAMP.
Composer for Symfony 3.4.

Add-ons
--------------
Bootstrap / Jquery / FontAwesome.

ORM
--------------
Doctrine

Bundles
--------------
Twig 

Installation
--------------
1.Download project or cline it with github =>

    git clone https://github.com/5-1/SnowTricks.git
    
 
If you are using LAMPP on Linux, check your permissions: Go to /opt/lampp/htdocs/ open a bash and type:

      $  sudo ls -l

Change permissions for everybody to be able to update informations in every repository's folders.

2.Symfony 3.4 and bundles installations Open bash in folder and type:

     composer install

3.Database creation:

     php bin/console doctrine:database:create
     
Then
    
     php bin/console doctrine:schema:update --force
   
Now, you can go on the URL:

[http://localhost/snowtricks/web](http://localhost/snowtricks/web) (if you put the folder on your apache root)

And enjoy :)

If you have any question, you can contact me with github

Thanks!
