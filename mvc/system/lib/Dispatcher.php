<?php 

class Dispatcher {
    protected $uri;
    protected $wp_template;
    protected $controller;    
    protected $method = 'index';
    protected $view   = 'index';

    public function __construct(){
        $this->uri         = $_SERVER['REQUEST_URI'] ;
        $this->uri         = rtrim(preg_replace(array('@\?.*$@' , '#^/#'), array('' , ''), $_SERVER['REQUEST_URI']) , '/');
        $this->wp_template = Helper::get_wp_template();
        
        $this->setDefaultView();
        $this->instance();
    }

    public function instance(){
        $uri   = array(); 
        $uri   = explode('/' , preg_replace('@-@' , '_' ,  $this->uri));
        $route = Router::matches($this->uri);

        if( $route!== NULL && is_array($route) ){
            $this->controller = (class_exists(ucfirst($route['controller']))) ? ucfirst($route['controller']) : 'Controller' ;  

            if(method_exists($this->controller, $route['method'])){
                $this->method = $route['method'];
            }

        }
        else{
            if($this->wp_template =='postTypeArchive' && class_exists(ucfirst($uri[0])) ){
                $this->controller = ucfirst($uri[0]);
            }
            else{
                $this->controller = (class_exists(ucfirst($this->wp_template)))   ?  ucfirst($this->wp_template) : 'Controller' ; 
            }


            if(method_exists($this->controller, end($uri))){
                $this->method = end($uri);
            } 
        }



        $controller = new $this->controller();
        $controller->init($this->view  , $this->method);  
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
    }
}