Simple example of MVC application skeleton and small CMS.

/www/ - web directory.
/core-lib/ - coreof MVC engine.
/app/ - application dir.

/conf.php - configuration file with class Conf.
/preload.php - class and lib loader
/www/index.php - just fake page
/www/main.php - real start page


Main URL patterm: http://hostname/controller/method/params/s/s/s/s...
Main controller: Main.
Main controller method: index.

class View - implementation of simplest template engine

class r - wrapper for get / post data

class session - wrapper for php session

class cookie - wrapper for http cookie

class files - wrapper for uploaded files
