<?php

namespace Db\Entity;

/**
 * Description of Item
 *
 * @author Less
 */
class Item extends \Mvc\Entity {
    
    protected static $table = 'items';
    
    protected static $fields = ['id', 'title', 'description', 'type', 'active', 'count', 'rating'];
    
    public static $typeList = ['simple', 'common', 'complicated', 'small', 'large'];
}
