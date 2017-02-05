## Rebusuje
Wordpress project to handle rebusy

## Motivation

Project is dedicated to our friend

## Installation
0. **Prerequisites:** PHP5.6.X, www server
1. Import the DB from ./wojciec8_wp2.sql.zip . The SQL inside the zip creates the database `wojciec8_wp2`.
2. In database client run:
  
  UPDATE `wp_options` SET `option_name` = REPLACE(`option_name`,'test5.loc','yourhostname.com');
  
  UPDATE `wp_options` SET `option_name` = REPLACE(`option_name`,'wojciech.mocek@gmail.com','your.email@server.com');
  
  UPDATE `wp_users` SET `user_email` = 'your.email@server.com' WHERE `user_email`='wojciech.mocek@gmail.com';

3. **Update wp-config.php!** - database password, database user, and so on
4. If sever cannot open files, be sure to grant proper file rights (on my Nginx+PHP-FPM I use chmod 775)
5. wp-admin login is: "test4", password "test4"



## API Reference

Most changes were done in:

wp-content/themes/fukasawa/*

wp-content/plugins/wp-rebus/*


## License

I don't know yet.

