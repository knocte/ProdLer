PRODLER - Readme File
----------------------

INSTALLATION
-------------

Dependencies:

 - Web server: tested with Apache. If you try this software with other web server, let us know!
 - PHP parser: tested with a module for Apache (it works with 4.3.4 version here).
 - DB engine: tested with MySQL. Note that the code is prepared for using other types of DBs (using php-dbx layer).
 - Smarty template system for PHP: download it from http://smarty.php.net/ . Place it on a directory level outside the prodler tree and with the name "libs". For example, if you place ProdLer on /var/www/html/prodler/, place Smarty tree on /var/www/html/libs/. Here it is working with version 2.6.6.
 - Gettext support enabled on web server: tested with Apache 2.
 - PEAR package: HTTP_Upload. (Install php-cli and php-pear packages. Then run 'pear install HTTP_Upload' from console.)
 - GD library for PHP. (In Mandrake, you should install the 'php-gd' package.)

After satisfying these dependencies, make sure to chmod 777 the two directories named 'templates_c' in the ProdLer tree. Adjust other permissions so as to allow the web server to access them (hopefully, the application should work without adjusting permissions if you just copy the tree inside the web server contents path; in my system, it is on '/var/www/html/').

Then, be sure to create the DataBases 'prodler' and 'prodler_images', following the SQL files contained in this directory (/prodler/info/).

Now that all have been installed, you could access your ProdLer website at, for example, http://yourserver/prodler/.

Then you will be redirected to a web-server-based authentication so as to enter on the Configuration Zone.

Check the contents of the hidden file prodler/config/.htaccess to see if it fit to your authorization needs. I recommend you to leave it with Digest type authentication.

To set up a new user with the actual paths in this htaccess file, follow this steps:

1) Create the directory /var/www/passwd
2) Create the file /var/www/passwd/groups with the following content:

ProdLer: first_user new_user last_user

3) Set the new passwords for the new 3 users, with the following commands:

# htdigest -c /var/www/passwd/passwd_digest "ProdLer Restricted Area" knocte

# htdigest /var/www/passwd/passwd_digest "ProdLer Restricted Area" new_user

# htdigest /var/www/passwd/passwd_digest "ProdLer Restricted Area" last_user

4) Set restrictive access permissions for these files:

# chown apache:apache /var/www/passwd/*
# chmod 400 /var/www/passwd/*


NOTES
------

All information messages which show operation results include a code that specifies the source of the message:

 [LM]: Library Message (probably caused by a 'die' function).
 [SM]: Server Message (this message is sent by the result of a form submission to the server).
 [CM]: Client Message (the one showed by JavaScript when the form data has been validated as incorrect.)



PROGRAMMING CONVENTIONS
------------------------

PHP naming
----------

NameOfTheFunction() : No spaces or underslashes ("_").
$xVariableName: No spaces or underslashes ("_") [however, there are some exceptions on the code]; where x is the type of the PHP object, and VariableName is a description of the variable.

 Types of objects:

  s - string
  i - integer
  a - array
  o - object (class)
  v - variable (can be many types)

 Examples: "$sMessage", "$iCodBrand", "$aCategories", "$vValue", etc.


Name of XHTML Objects
---------------------

"xxxAbcdEfgh" : xxx is the type of the HTML Object, Abcd and Efgh are words that describe the object.

 Types of objects:

  txt - Input type="text"
  rad - Input type="radio"
  chk - Input type="checkbox"
  btn - Input button (type="submit", type="reset", etc.)
  hid - Input type="hidden"
  sel - Select
  txa - Textarea

 Examples: "txtNewPrice", "selCategory", "radBrand", "txaSpecs", etc.


JavaScript naming
-----------------

This is the unique language to which there isn't defined a rule for naming variables yet. However, functions follow the same rule as PHP.

Send us your comments if you think you could help with this subject.


Coding techniques
-----------------

To maintain clean the code, we recommend that you check these different warnings:

 1) Do not write 'else' after a 'return' statement.
 2) If the events onkeyup and/or onkeypress have been defined, with scripting, for a form control (for example, a textarea), it is more likely that it should have also the same behaviour for the onchange event.
 3) A very common mistake in writing XHTML layout is to use the deprecated tag <center>.
