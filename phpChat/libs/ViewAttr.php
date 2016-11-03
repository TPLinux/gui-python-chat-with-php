<?php 

class ViewAttr{

    // static html attr
    public $name = '';
    public $cls = '';
    public $id = '';
    public $value = '';
    // Form info 
    public $method = '';
    public $action = '';
    public $enctype = '';
    // Inputs info
    public $type = '';
    public $placeholder = '';
    
    // clear pervious attrs
    public function clear(){
        // static html attr
        $this->name = '';
        $this->cls = '';
        $this->id = '';
        $this->value = '';
        // Form info 
        $this->method = '';
        $this->action = '';
        $this->enctype = '';
        // Inputs info
        $this->type = '';
        $this->placeholder = '';
    }
    }

?>
