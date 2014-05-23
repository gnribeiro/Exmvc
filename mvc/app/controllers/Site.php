<?php

class Site extends Controller {
    
    public function __construct(){
        parent::__construct();
    }

    public function page(){       
    /*
    $posts = Post::query()
    ->limit(5)
    ->where('post_status', 'publish')
    ->sort_by('post_title')
    ->order('ASC')
    ->find();

    */

       
    global $post;
echo single_cat_title( '', false );
         while ( have_posts() ) {
                the_post();
               echo $post->post_title;
            } 
        $content = $this->view->render('teste');
        $this->content($content);
        echo "<pre>".var_dump($post)."</pre>";
        echo "<pre>".var_dump(get_post_meta($post->ID, "_gomvc_location", true))."</pre>";
        
        echo var_dump(is_single());
        echo var_dump(is_post_type_archive());

        echo var_dump(is_attachment());
        echo var_dump( is_category() );
        $teste = 'Dispatcher';

        $teste = new $teste();
        $method = "index";
        if(method_exists(__CLASS__, $method)){
            $this->{$method}();
        }
       $this->setDefaultView();
    }

    public function index(){
        echo "index333";
    }


}