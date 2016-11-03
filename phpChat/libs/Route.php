
<?php

class Route {

    public function __construct(){
        // تهيئة مصفوفة لتخزين الطرق المضافة
        $this->routes = [];
    }
    // هذه الدالة تقوم باضافة طريق جديد
    public function addRoute($route,$cont){
        $this->routes[$route] = $cont;
    }

    // استدعاء الطريق
    public function getRoute($route){
        $route = explode('/' , $route);

        if(isset($route[2]))
            $arr_route =  "/" . $route[1] . "/" . $route[2];
        else
            $arr_route =  "/" . $route[1];
        //echo var_dump($this->routes);
        
        if(array_key_exists($arr_route . "/GET",$this->routes)){
            $controller_file = explode("@",$this->routes[$arr_route . "/GET"]);

            require_once("./controllers/" . $controller_file[0] . ".php");
            
            if(isset($route[3]) ){
                $par = $route[3];
                $controller = new $controller_file[0]();
                $controller->loadModel($controller_file[0]);
                $controller->$controller_file[1]($par);
            }else{
                //Controller::redirect(URL . "/index");
                $v = new View();
                $v->view("404");
            }
        }elseif(array_key_exists($arr_route,$this->routes)){
            $controller_file = explode("@",$this->routes[$arr_route]);
            require_once("./controllers/" . $controller_file[0] . ".php");
            $controller = new $controller_file[0]();
            $controller->loadModel($controller_file[0]);
            if(!isset($controller_file[1]))
                die("You must specify the method for route:" . $this->routes[$arr_route]);
            if(method_exists($controller,$controller_file[1]))
                $controller->$controller_file[1]();
            else
                die("Method : <b>'" . $controller_file[1] . "()'</b> dose not exists in class : <b>'" . ucfirst($controller_file[0]) ."'</b>!");
        }else{
            $v = new View();
            $v->view("404");
        }
    }


}

$r = new Route();

?>
