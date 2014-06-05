<?php
class Controller_Galleries extends Controller {
    
    public function __construct(){
        parent::__construct();
        
    }

    public function lista(){

    }
    public function galery2(){
       
       echo get_post_type();
       $customPostTaxonomies = get_terms(ucfirst(get_post_type()));
       
       echo var_dump( $customPostTaxonomies );
  

        $content = $this->view->render($this->defauld_view);
        $this->content($content);
    }
}