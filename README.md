# Chat MVC 
An MVC chat application example.  

## Requirement :
- apache server <=2.4
- php version <= 5.6

## Configuration : 
- import the schema in dump/db_chat
- Copy the app/apache/apache.conf.dist file to app/apache/apache.conf and replace <PATH_TO_YOUR_PROJECT> by your project path
- Copy the app/config/config.php.dist file to app/config/config.php and replace the <db_user> and <db_pwd> by your credentials 
- Run php composer.phar run-script load-project
- Go to http://chat.localhost 