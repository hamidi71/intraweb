<?php

/**
 * Created by IntelliJ IDEA.
 * User: Baddi
 * Date: 11-5-2017
 * Time: 22:29
 */
   abstract class ActionController {
        protected  $parms=array();
        protected $request;
       public function setRequest($req){
            $this->request=$req;
        }

       public function setParametre($param){
           $this->params=$param;
       }
       abstract public function init();

    }