<?php

namespace Db\Entity;

/**
 * Description of User
 *
 * @author Less
 */
class User extends \Mvc\Entity {
    
    protected static $fields = ['id', 'name', 'login', 'pass', 'email'];
    
    protected static $table = 'users';
    
    
}
