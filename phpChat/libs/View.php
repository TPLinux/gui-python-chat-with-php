<?php
class View extends ViewAttr{
    
    public function __construct(){
        
    }
    public function view($tpl){
        $path = "views/".$tpl.".php";
        if(file_exists($path)){
            require_once("$path");
        }else{
            echo "The '<b style='color:blue;'>views/$tpl.php</b>' template isn't avilable" ;
            die();
        }
        return $this;
    }
    
    /* static html attr */
    // set name attr
    public function name($name){
        $this->name = "name='" . $name . "' ";
        return $this;
    }
    // set id attr
    public function id($id){
        $this->id = "id='" . $id . "' ";
        return $this;
    }
    // set class attr
    public function cls($cls){
        $this->cls = "class='" . $cls . "' ";
        return $this;
    }
    // set value attr
    public function value($value){
        $this->value = "value='" . $value . "' ";
        return $this;
    }
    // do <br/>
    public function br($num = 1){
        $n = 1;
        do{
            echo "\n<br/>";
            $n++;
        }while($n <= $num);
    }
    /* End static html attr*/
    
    /* Form tpl start */
    public function method($method){
        $this->method = "method='" . $method . "' ";
        return $this;
    }
    
    public function action($action){
        $this->action = "action='" . $action . "' ";
        return $this;
    }
    public function enctype($enctype){
        $this->enctype = "enctype='" . $enctype . "' ";
        return $this;
    }
    public function setForm(){
        echo "<form {$this->name}{$this->cls}{$this->id}{$this->action}{$this->method}{$this->enctype}>";
        $this->clear();
    }
    
    public function endForm(){
        echo "\n</form>";
    }
    /* Form tpl end */
    /* Input tpl start */
    public function type($type){
        $this->type = "type='" . $type . "' ";
        return $this;
    }
    public function placeholder($placeholder){
        $this->placeholder = "placeholder='" . $placeholder . "' ";
        return $this;
    }
    
    public function setInput(){
        echo "\n<input {$this->name}{$this->id}{$this->cls}{$this->type}{$this->value}{$this->placeholder}/>";
        $this->clear();
    }
    /* Input tpl END */
}
?>
