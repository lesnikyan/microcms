<?php


namespace Mvc;

/**
 * Description of Model
 *
 * @author Less
 */
class Model {
    
    protected static $entity;
    
    protected $table;
    
    const FIRST = -1;
    
    const LAST = -2;
    
    /**
     * @var \PDO
     */
    protected static $db = null;
    
    private $lastQueryStatus = false;
    
    public function __construct($entity=null) {
        //$this->entity = $entity;
//        p('full: ' . static::fullEntity());
        $this->table = forward_static_call([static::fullEntity(), 'getTable']);
        self::getDB();
        self::$db->query("SET NAMES UTF8;");
    }
    
    public static function getDB(){
        if(self::$db == null){
            self::$db = new \PDO(Conf::dbConnectionString, Conf::dbUser, Conf::dbPass);
        }
        return self::$db;
    }
    
    // Base SQL execution methods:
    
    /**
     * 
     * @param string $sql
     * @param array $data
     * @return \PDOStatement
     */
    public function query($sql, $data=[]){
//        p($sql);
//        pr($data);
        $stat = self::$db->prepare($sql); // get PdoStatement object
//        p($stat->errorInfo());
        $this->lastQueryStatus = $stat->execute($data);
        return $stat; // ->fetchAll(PDO::FETCH_CLASS);
    }
    
    public function select($sql, $data=[], $isObj = false){
        $res = $this->query($sql, $data);
        $resType = $isObj ? \PDO::FETCH_OBJ : \PDO::FETCH_ASSOC;
        if($this->lastQueryStatus){
            return $res->fetchAll($resType); // method from PdoStatement
        }
        return [];
    }
    
    public function insert($sql, $data=[]){
        $res = $this->query($sql, $data);
        if($this->lastQueryStatus){
            return self::$db->lastInsertId(); // method from PDO
        }
        return null;
    }
    
    public function update($sql, $data=[]){
        $res = $this->query($sql, $data);
        if($this->lastQueryStatus){
            return $res->rowCount(); // method from PdoStatement
        }
        return 0;
    }
    
    public function delete($sql, $params=[]){
        return $this->update($sql, $params);
    }
    
    static function fullEntity(){
        return '\\Db\\Entity\\' . static::$entity;
    }
    
    
    // CRUD methods
    
    function entityFields(){
        return forward_static_call([static::fullEntity(), 'getFields']);
    }
    
    /**
     * 
     * @param type $condition
     * @param type $limit
     * @param type $order
     * @return \Mvc\Entity | []
     */
    public function findResult($condition, $limit=null, $order=null){
        $fields = $this->entityFields();
        $fieldStr = implode (', ', 
            array_map( function($f){ return self::beqt($f); }, $fields));
        $conditionStr = ' 1 ';
        $params = [];
        if(is_numeric($condition)){
            // select by id
            $arg = intval($condition);
            $limit = [0, 1];
            if($arg > 0){
                $conditionStr = '`id` = ?';
                $params = [$arg];
            } else if($arg < 0){
                if($arg == self::FIRST){
                    $order = 'id ASC';
                } else if($arg == self::LAST){
                    $order = 'id DESC';
                }
            } else {
                return [];
            }
            
        } else if(is_string($condition)){
            // select by sql condition: name = 'Some Name'
            $conditionStr = $condition;
        } else if(is_array ($condition)){
            // select by field=? set
            // TODO: implement case with field-val conditions
            $conditionVars = $this->arrayCondition($condition);
            $params = $conditionVars['params'];
            $conditionStr = $conditionVars['str'];
        }
        $orderStr = '';
        $limitStr = '';
        if($order){
            $orderStr = "ORDER BY $order";
        }
        if($limit){
            $limitStr = "LIMIT {$limit[0]}, {$limit[1]}";
        }
        
        $sql = "SELECT {$fieldStr} FROM {$this->table} WHERE {$conditionStr} {$orderStr} {$limitStr} ;";
        $data = $this->select($sql, $params);
        return $data;
    }
    
    function arrayCondition($condition){
        $conds = [];
        $fields = $this->entityFields();
        foreach($condition as $field => $val){
            if(in_array($field, $fields)){
                $conds[] = self::beqt($field) . " = ? ";
                $params[] = $val;
            }
        }
        $conditionStr = implode(' AND ', $conds);
        return ['str' => $conditionStr, 'params' => $params];
    }
    
    /**
     * 
     * @param int | array $condition
     * @return \Mvc\Entity
     */
    function find($condition){
        $data = $this->findResult($condition, [0,1], 'id DESC');
        if(empty($data)){
            return null;
        }
        $item = static::entityByData(static::fullEntity(), $data[0]);
        return $item;
    }
    
    function findList($condition=null, $limit=null, $order=null){
        $data = $this->findResult($condition, $limit, $order);
        $res = [];
        foreach ($data as $row){
            $res[] = static::entityByData(static::fullEntity(), $row);
        }
        return $res;
    }
    
    static function entityByData($entityClass, $data){
        return new $entityClass($data);
    }
    
    function fieldsStr($fields){
        $fieldStr = implode (', ', 
            array_map( function($f){ return self::beqt($f); }, $fields));
        return $fieldStr;
    }
    
    public function save(Entity $entity){
        // make data
        $data = $entity->getData();
        if($entity->id){
            // update
            $dataList = [];
            $vals = [];
            foreach($entity->getData() as $f => $val){
                if($f == 'id'){
                    continue;
                }
                $dataList[] = "`$f` = ?";
                $vals[] = $val;
            }
            $dataStr = implode(', ', $dataList);
            $vals[] = $entity->id;
            $sql = "UPDATE {$this->table} SET {$dataStr} WHERE `id` = ?;";
            return $this->update($sql, $vals);
        } else {
            // create
            $this->create($entity);
        }
    }
    
    public function create(Entity $entity){
        $data = $entity->getData();
        $fields = $this->entityFields();
        $fields = array_diff($fields, ['id']);
        $fieldStr = $this->fieldsStr($fields);
        $vals = [];
        foreach($fields as $f){
            $vals[] = $data[$f];
        }
        $paramStr = implode(', ', array_fill(0, count($vals), '?'));
        $sql = "INSERT INTO `{$this->table}` ({$fieldStr}) VALUES ($paramStr);";
        $id = $this->insert($sql, $vals);
        $entity->id = $id;
        return $id;
    }
    
    public function del($id){
        $sql = "DELETE FROM `{$this->table}` WHERE `id` = ? ;";
        $this->delete($sql, [$id]);
    }
    
    /**
     * wrap word with back quotes
     * @param string $str
     */
    function beqt($str){
        return "`{$str}`";
    }
    
}