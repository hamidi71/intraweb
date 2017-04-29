<?php

/**
 * Created by IntelliJ IDEA.
 * User: Baddi
 * Date: 29-4-2017
 * Time: 20:40
 */
class Autoload{
    const URL_CONTROLLER = "Index";
    const URL_ACTION     = "index";

    public function __construct() {
    $this->parseUri();
    }
    public function run(){

    }
    protected function parseUri(){
        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");
        $path=explode('web.php/',$path);
        @list($controller, $action, $params)=explode('/',$path[1],3);
       if(empty($controller)) $controller=self::URL_CONTROLLER;
       if(empty($action)) $action=self::URL_ACTION;
       if(isset($controller)) $this->setController($controller);


    }
    public function setController($controller){
        //eerste leter hoofdleter en con uvfirst en strlower
        $controller=ucfirst(strtolower($controller)).'Controller.php';
        $p=  realpath(dirname(__FILE__) . '/../app/controllers/')."/".$controller;
        echo $p;

        if(!file_exists($p))throw new InvalidArgumentException(
            "the controller '$controller' does not exist.");
        ;

           
        ;

    }

}