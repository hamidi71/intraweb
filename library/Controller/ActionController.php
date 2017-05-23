<?php

/**
 * Created by IntelliJ IDEA.
 * User: Baddi
 * Date: 11-5-2017
 * Time: 22:29
 */
   abstract class ActionController {
       protected $view=true;
        protected  $parms=array();
        protected $request;
       protected $layout="default.php";
       private $path_layout="../../app/layouts/";
    //$result de action en $view url van de  action
       public function views($result,$view){
       $ContentLayout=$this->getContentsLayout(realpath(dirname(__FILE__) ."/".$this->path_layout.$this->getLayout()));
        echo $ContentLayout;
       }
        public function __construct(){
           //init aanroepen bij elke Controller
         $this->init();
        }

       public function setRequest($req){
            $this->request=$req;
        }

       public function setParametre($param){
           $this->params=$param;
       }
       abstract public function init();
       public function setLayout($layout){
           $this->layout =$layout.".php";
           if(!file_exists(realpath(dirname(__FILE__) ."/".$this->path_layout.$this->getLayout())))
               throw new Exception(" layout niet gevonden ".$this->layout);

       }
       public function getLayout(){
           return $this->layout;
       }

       public function getContentsLayout($path){
           ob_start();
           include($path);
           $str = ob_get_clean();
           ob_end_flush();
           return $str;

       }
   }
