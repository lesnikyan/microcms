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
<?php
    // Typical using:
    $view = new View('dir/file', ['varName' => $val,...]);
    $view->varName = $val;
    $text = $view->render();    // get result as string value
    $view->render(true);        // print result to output
    // Simple using:
    $view = new View('tplfile', 'Simple string content'); // same as ['content' => 'Simple string content']
    $view = new Value(); // view with default string as result
    $view = new View(null, 'String content'); // view with string content as result
?>

/**************** Http Request *******************\

class r - wrapper for get / post data

class session - wrapper for php session

class cookie - wrapper for http cookie

class files - wrapper for uploaded files

/**************** DataBase *******************\

class \Mvc\Entity - superclass for DB entities. Example:
<?php
    namespace Db\Entity;
    class User extends \Mvc\Entity {
            /* fields of entity (same names as fields in DB) */
        protected static $fields = ['id', 'name', 'login', 'pass', 'email'];
            /* name of DB table */
        protected static $table = 'users';
    }
?>

Entity::getFields(); - return list of fields
Entity::getTable(); - return name of table
Entity::getClass(); - return name of class
->getData(); - return values as assoc array [field => val]
->setData($data); - set new values of fields
->{fieldName} - get or set value by field: $user->name = 'Vasya';

class \Mvc\Model - superclass for DAO models. Example:
<?php
    namespace Db\Model;
    class Users extends \Mvc\Model {
        /* Name of target entity class */
        protected static $entity = 'User';
    }
?>

Basic methods:

$model->query($sql, $data); - executes sql request $data - assoc array [field => value]
$model->select($sql, $data); - executes selection 
$model->insert($sql, $data); - executes insertion
$model->update($sql, $data); - executes update
$model->delete($sql, $data); - executes delete

CRUD methods:

Entity $model->find($condition); - get one entity record
array $model->findList($condition=null, $limit=null, $order=null); - get list of entities
$model->create(Entity $entity); - create new entity record
$model->save(Entity $entity); - update or create record by Entity object
$model->del($id); - delete record by id;

array $model->findResult($condition, $limit=null, $order=null); - get list by conditions as array of assoc arrays

