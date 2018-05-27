<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Db;

/**
 * Description of Model
 *
 * @author Less
 */
class Model {
    
    protected $table;
    
    protected function __construct($table) {
        $this->table = $table;
    }
    
    /**
     * 
     * @param string $table
     * @return \Db\Model
     */
    public static function get($table){
        return new Model($table);
    }
    
    public function query($sql, $data){}
    public function select($sql, $data){}
    public function update($data, $condition){}
    public function insert($data){}
    public function deleteQuery($sql){}
    
    public function find($condition){
        $sql = '';
        if(is_int($condition)){
            // select by id
        } else if(is_array ($condition)){
            // select by field=? set
        } else {
            // select by sql condition: name = 'Some Name'
        }
        
    }
    public function save(Entity $entity){
        // make data
        $data = [];
        
        $condition = [];
        // update
        return $this->update($data, $condition);
    }
    
    public function create(){}
    public function delete($condition){}
    
    
    
}
