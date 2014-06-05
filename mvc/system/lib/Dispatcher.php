<?php 

class Dispatcher {
    protected $uri;
    protected $wp_template;
    protected $controller;    
    protected $method = 'index';
    protected $view   = 'index';
    protected $controllerNamespace = 'Controller_';
    protected $defaultsSingles   =  array('post', 'page', 'attachment' );
    protected $site;


    public function __construct(){  
      
        $this->uri         = $_SERVER['REQUEST_URI'] ;
        $this->uri         = rtrim(preg_replace(array('@\?.*$@' , '#^/#' , '@page/[\d]+@'), array('' , '', ''), $_SERVER['REQUEST_URI']) , '/');
        $this->wp_template = Helper::get_wp_template();
        $this->site        = Helper::load_config('site');
        
        if( $this->site['translate_uri'] && pll_current_language()!= $this->site['default_lang'])
            $this->convert_lang_uri();

        $this->setDefaultView();
        $this->instance();


    }

    protected function convert_lang_uri(){


        if($this->site['protocol'].$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'] === pll_home_url()){
            $this->uri ='';
        }

        else{
            $uri     = explode('/', $this->uri);
            $new_uri = array();
            $lang    = $this->site['default_lang'];
            
            foreach ($uri as  $value) {
                if(Helper::is_categorie($value)){
                    $new_uri[] = Helper::lang_category_slug($value , $lang);
                }
                elseif(is_page($value)){
                    $new_uri[] = Helper::lang_page_slug($value , $lang);
                }
                elseif(Helper::is_post($value)){
                    $new_uri[] = Helper::lang_post_slug($value , $lang);
                }
                else{
                   $new_uri[] =  $value;
                }
            }

            $this->uri = implode('/', $new_uri);
        }
         
    }


    public function instance(){

        $uri   = array(); 
        $uri   = explode('/' , preg_replace('@-@' , '_' ,  $this->uri));
        $route = Router::matches($this->uri);

        if( $route!== NULL && is_array($route) ){

 
            $this->controller = (class_exists($this->controllerNamespace .  ucfirst($route['controller']))) ? $this->controllerNamespace . ucfirst($route['controller']) : 'Controller' ;  

            if(method_exists($this->controller, $route['method'])){
                $this->method = $route['method'];
            }

        }
        else{
   
            if( $this->wp_template =='postTypeArchive' && class_exists($this->controllerNamespace . ucfirst($uri[0])) || 
                $this->wp_template =='single' && !in_array(get_post_type() , $this->defaultsSingles )){
                $this->controller = $this->controllerNamespace . ucfirst($uri[0]);
            }
            else{

                $this->controller = (class_exists(  $this->controllerNamespace . ucfirst($this->wp_template)))   ?  $this->controllerNamespace . ucfirst($this->wp_template) : 'Controller' ; 
            }

            if(method_exists($this->controller, end($uri))){
                $this->method = end($uri);
            } 
        }


        $controller = new $this->controller();
        $controller->init($this->view  , $this->method, $this->controller);  
    }


    public function setDefaultView() {

        if($this->uri !== ''){
            $uri   = explode('/', $this->uri); 
            $count = count($uri);
            $index = 0; 
            $file  =$this->wp_template;
           
            if(file_exists(APPPATH.'views/'.$file.EXT))
                $this->view = $file;
            
           while($index < $count){
            
                $path = implode(DIRECTORY_SEPARATOR, $uri).DIRECTORY_SEPARATOR.$file;

                if(file_exists( APPPATH.'views/'.$path.EXT )){
                    $this->view = $path ;
                    break;
                }
                array_pop($uri);
                $index++;
           }
        }
        else{
             $file  =$this->wp_template;
             if(file_exists(APPPATH.'views/'.$file.EXT))
                $this->view = $file;
        }
    }
}