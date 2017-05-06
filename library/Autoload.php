<?php
/**
 * Created by IntelliJ IDEA.
 * User: Baddi
 * Date: 29-4-2017
 * Time: 20:40
 */
    $dir_iterator = new RecursiveDirectoryIterator(realpath(dirname(__FILE__)."/../")."/library");
    $dir_iterator2 = new RecursiveDirectoryIterator(realpath(dirname(__FILE__)."/../")."/app/models");
    $dir_iterator3 = new RecursiveDirectoryIterator(realpath(dirname(__FILE__)."/../")."/app/forms");
    $dir_iterator4 = new RecursiveDirectoryIterator(realpath(dirname(__FILE__)."/../")."/app/controllers");
    getfi($dir_iterator);
    getfi($dir_iterator2);
    getfi($dir_iterator3);
    getfi($dir_iterator4);

    function getfi($dir_iterator){
        $iterator = new RecursiveIteratorIterator($dir_iterator);
        foreach ($iterator as $file) {
            if (preg_match('/\.php$/', $file)) {
                require_once ($file);
            }
        }
    }

    //require_once '../app/controllers/IndexController.php';
    class Autoload{
        const URL_CONTROLLER = "Index";
        const URL_ACTION     = "index";
        const DEFAULT_CONTROLLER = "IndexController";
        const DEFAULT_ACTION     = "index";
        protected $controller=self::DEFAULT_CONTROLLER;
        protected $action=self::DEFAULT_ACTION;
        protected  $param=array();

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
           if(isset($action)) $this->setAction($action);
           if(isset($params)) {
               $params=explode('/',$params);
               for($i=0;$i<count($params);$i+=2){
                   $tab[$params[$i]]=$params[$i+1];
               }
           }

           var_dump($tab);

        }
        public function setController($controller){
            //eerste leter hoofdleter en con uvfirst en strlower
            $controller=ucfirst(strtolower($controller)).'Controller';
            $p=  realpath(dirname(__FILE__) . '/../app/controllers').'/'.$controller.'.php';
            if(!file_exists($p))throw new InvalidArgumentException(
                "the controller '$controller' does not exist.");

            $this->controller=$controller;
            return $this;
        }

        public function setAction($action){
            $action=strtolower($action).'Action';
            $reflector=new ReflectionClass($this->controller);
           if(! $reflector->hasMethod($action)) throw new InvalidArgumentException(
               "the action '$action' does not exist in the ".$this->controller) ;
           $this->action=$action;
           return $this;

        }

        public function setParams($param){
            $this->param=$param;
            return $this;

        }

    }