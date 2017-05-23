<?php
/**
 * Created by IntelliJ IDEA.
 * User: Baddi
 * Date: 29-4-2017
 * Time: 20:40
 */
//zoeken binene de folder
    $dir_iterator = new RecursiveDirectoryIterator(realpath(dirname(__FILE__)."/../")."/library");
    $dir_iterator2 = new RecursiveDirectoryIterator(realpath(dirname(__FILE__)."/../")."/app/models");
    $dir_iterator3 = new RecursiveDirectoryIterator(realpath(dirname(__FILE__)."/../")."/app/forms");
    $dir_iterator4 = new RecursiveDirectoryIterator(realpath(dirname(__FILE__)."/../")."/app/controllers");
    getfi($dir_iterator);
    getfi($dir_iterator2);
    getfi($dir_iterator3);
    getfi($dir_iterator4);
//require the pages.php
    function getfi($dir_iterator){
        $iterator = new RecursiveIteratorIterator($dir_iterator);
        foreach ($iterator as $file) {
            if (preg_match('/\.php$/', $file)) {
                require_once ($file);
            }
        }
    }

    //require_once '../app/controllers/IndexController.php';
    //start methode project
    class Autoload{
        const URL_CONTROLLER = "Index";
        const URL_ACTION     = "index";
        const DEFAULT_CONTROLLER = "IndexController";
        const DEFAULT_ACTION     = "index";
        protected $controller=self::DEFAULT_CONTROLLER;
        protected $action=self::DEFAULT_ACTION;
        protected  $param=array();
        protected $view="app/views/";

        public function __construct() {

        }
//startfunctie
        public function run(){
            $this->parseUri();
            $this->setView();
            $controller=new $this->controller();
            $controller->setParametre($this->param);
            $controller-> setRequest($this->getMethode());
            //$controller->{$this->action};
           //echo'test run'; naam van de method
            $result=$controller->{$this->action}();
            $controller->views($result,$this->view);
        }
//get data from url
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
           $this->action=$action;//indexAction
           return $this;

        }

        public function setParams($param){
            $this->param=$param;
            return $this;
        }

        public function setView(){
         //contro/action/ps
            //voorbeeld  app/views/Index/index.php
            $action=explode('Action', $this->action);//index
            $controller=explode('Controller', $this->controller);
            $this->view.=$controller[0].'/'.$action[0].'.php';

        }
        public function getMethode(){
            if($_SERVER['REQUEST_METHOD']=='POST')return $_POST;
            else return $_GET;
        }
    }