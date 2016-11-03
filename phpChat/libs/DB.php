<?php

class DB extends PDO {

    public $where = "";
    public function __construct(){
        /* You can find this info and edit it at CONFIG/DB.PHP */
        parent::__construct(
            DB_TYPE. // database type
            ":host=".DB_HOST. // the host
            ";dbname=".DB_NAME. // database name
            ";charset=utf8" // unicode
            ,DB_USER, // database user
            DB_PASS
        );
        parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }


    public function Oops(){
        return false;
        //die("<b style='color:red;'>Oops, Something wrong</b>");
    }
    public  function table($table){
        $this->table = $table;
        return $this;
       
    }

    public function at($cond){
        $this->where = " $cond";
        return $this;
    }
    // select from table
    public function select($cols){
        try{
            $this->sql = "SELECT {$cols} FROM {$this->table} {$this->where}";
            $stmt = parent::prepare($this->sql);
            $stmt->execute();
            $this->rowCount = $stmt->rowCount();
            if($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }else{
                return false;
            }
            return $this;
        }catch(PDOException $e){
            $this->Oops();
        }
        
    }
    // delete from table

    public function delete(){
        try{
            $this->sql = "DELETE  FROM {$this->table} {$this->where}";
            $stmt = parent::prepare($this->sql);
            $stmt->execute();
            return $this;
        }catch(PDOException $e){
            $this->Oops();
        }
    }

    public function insert($values){
        $this->values = $values;
        try{
            $this->sql = "INSERT INTO {$this->table} {$this->values} ";
            $stmt = parent::prepare($this->sql);
            $stmt->execute();
            return $this;
        }catch(PDOException $e){
            $this->Oops();
        }
    }

    
    public function update($set){
        
        try{
            $this->sql = "UPDATE {$this->table} SET $set";
            $stmt = parent::prepare($this->sql);
            $stmt->execute();
            return $this;
        }catch(PDOException $e){
            echo $this->sql;
            //echo $e->getMessage();
            $this->Oops();
        }
    }
    
    
    public function anotherSelect($sql){
        try{
            $this->sql = "$sql";
            $stmt = parent::prepare($this->sql);
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }else{
                return null;
            }
            return $this;
        }catch(PDOException $e){
            $this->Oops();
        }
    }
    
    
    public function execSql($sql){
        try{
            $stmt = parent::prepare($sql);
            $stmt->execute();
            return $this;
        }catch(PDOException $e){
            $this->Oops();
        }
    }
    
    public function doSql($sql){
        try{
            $this->sql = "$sql";
            $stmt = parent::prepare($this->sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }catch(PDOException $e){
            $this->Oops();
        }

    }
}


?>
