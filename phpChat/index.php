<?php
//error_reporting(0);
// config files
require_once("./config/pathes.php");
require_once("./config/db.php");

// libs
require_once("./libs/Controller.php");
require_once("./libs/DB.php");
require_once("./libs/Model.php");
require_once("./libs/Session.php");
require_once("./libs/simple_html_dom.php");
require_once("./libs/ViewAttr.php");
require_once("./libs/View.php");
require_once("./libs/Route.php");


// Routes 
$r->addRoute("/index","index@index");
$r->addRoute("/login","index@login");
$r->addRoute("/chat","index@chat");
$r->addRoute("/newMsg","index@newMsg");
$r->addRoute("/logout","index@logout");
/* 
   set GET to pass parameters to method getUser
   we must go to http://url.com/index/users/2
   we get user id 2
   for more than one parameter we should type
   http://url.com/index/users/2|3|4|5
   then we will explode it in getUser by this :
   explode('|',$parameter);
   ------------------------------
   $r->addRoute("/index/users/GET","index@getUser");
*/ 

if(isset($_GET['route'])){
    $route = "/" . rtrim($_GET['route'],"/");
    $r->getRoute($route);
}else{
    Controller::redirect(URL . "/index");
}


?>
