<?php
/**
 * Created by IntelliJ IDEA.
 * User: Baddi
 * Date: 29-4-2017
 * Time: 22:06
 */
    class IndexController extends  ActionController {

        public function init(){
            //test is de layout van deze controller
           $this->setLayout('test');
        }

        public function indexAction(){
            echo 'test index';

            return array('id'=>1);
        }



    }
