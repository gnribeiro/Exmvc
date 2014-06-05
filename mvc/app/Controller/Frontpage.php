<?php

class Controller_Frontpage extends Controller {
    
    public function __construct(){
        parent::__construct();
    }
    
    

    public function index(){
        $content = $this->view->render('frontpage');
        $this->content($content);
    }

    public function lista(){

    }
    public function lista2(){
        
    }
}