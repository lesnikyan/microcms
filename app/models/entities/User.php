<?php

namespace Db\Entity;

/**
 * Description of User
 *
 * @author Less
 */
class User extends \Db\Entity {
    
    protected static $fields = ['id', 'name', 'login', 'pass', 'auth_key'];
    
    protected static $table = 'user';
    
    
}
