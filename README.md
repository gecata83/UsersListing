### To run the project

Clone the git repository on your machine.
Execute "composer.phar update" in the project main folder terminal
### Apache setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

```apache
<VirtualHost *:80>
    ServerName users-list.fb
    ServerAlias www.users-list.fb
    DocumentRoot NEED-A-FULL-PATH/UsersListing/public
    <Directory NEED-A-FULL-PATH/UsersListing/public>
        Options +Indexes +FollowSymLinks +MultiViews
        AllowOverride All
        Require all granted
	RewriteEngine On
	# The following rule tells Apache that if the requested filename
	# exists, simply serve it.
	RewriteCond %{REQUEST_FILENAME} -s [OR]
	RewriteCond %{REQUEST_FILENAME} -l [OR]
	RewriteCond %{REQUEST_FILENAME} -d
	RewriteRule ^.*$ - [L]
	# The following rewrites all other queries to index.php. The 
	# condition ensures that if you are using Apache aliases to do
	# mass virtual hosting or installed the project in a subdirectory,
	# the base path will be prepended to allow proper resolution of
	# the index.php file; it will work in non-aliased environments
	# as well, providing a safe, one-size fits all solution.
	RewriteCond %{REQUEST_URI}::$1 ^(/.+)/(.*)::\2$
	RewriteRule ^(.*) - [E=BASE:%1]
	RewriteRule ^(.*)$ %{ENV:BASE}/index.php [L]
    </Directory>
</VirtualHost>
```
rewrite mode should be enabled
add "users-list.fb" to your hosts file, enable your virtual host site, restart apache.
 THAT IS ALL
### This project has been made using Zend Sceleton Application as a base