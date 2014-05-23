<?php

Class Controller{
    protected $view;
    protected $defauld_view = 'index';
    protected $uri;

    public function __construct() {
        $this->view = View::factory();  
        $this->uri  = rtrim(preg_replace(array('@\?.*$@' , '#^/#'), array('' , ''), $_SERVER['REQUEST_URI']),"/");
    }

    public function before() {
      
    }

    public function after() {
       
    }

    public function init( $defauld_view = 'index' , $method = 'index') {
        $this->defauld_view = $defauld_view;

        $this->before();
        
        if(method_exists(__CLASS__, $method)){
            $this->{$method}();
        }
        else{
           $this->index(); 
        } 
        $this->after();
    }


    public function index() {
        try{
            $content = $this->view->render($this->defauld_view);
        }
        catch(Exception $e){
            $content = '';

        }

        $this->content($content);
    }

    public function set_header(){
        $this->view->data = Helper::siteInfo();
        $this->view->head = $this->view->render('template/head');
        
        return $this->view->render('template/header');
    }


    public function set_footer(){
        return $this->view->head = $this->view->render('template/footer');
    }


    public function content($content = '') {
        echo $this->set_header();
        $this->view->content = $content;
        echo $this->view->render('template/main');
        echo  $this->set_footer();
    }


    protected function set_flash($type, $message) {
        $this->init_flash();
        $_SESSION['wp_mvc_flash'][$type] = $message;
    }

    protected function unset_flash($type) {
        $this->init_flash();
        unset($_SESSION['wp_mvc_flash'][$type]);
    }

    protected function get_flash($type) {
        $this->init_flash();
        $message = empty($_SESSION['wp_mvc_flash'][$type]) ? null : $_SESSION['wp_mvc_flash'][$type];
        return $message;
    }


    protected function get_all_flashes() {
        $this->init_flash();
        return $_SESSION['wp_mvc_flash'];
    }


    public function flash($type, $message=null) {
        if (func_num_args() == 1) {
            $message = $this->get_flash($type);
            $this->unset_flash($type);
            return $message;
        }
        $this->set_flash($type, $message);
    }


    public function display_flash() {
        $flashes = $this->get_all_flashes();
        $html = '';
        if (!empty($flashes)) {
            foreach ($flashes as $type => $message) {
                $classes = array();
                $classes[] = $type;
                if ($this->is_admin) {
                    if ($type == 'notice') {
                        $classes[] = 'updated';
                    }
                }
                $html .= '
                    <div id="message" class="'.implode(' ', $classes).'">
                        <p>
                            '.$message.'
                        </p>
                    </div>';
                $this->unset_flash($type);
            }
        }
        echo $html;
    }

    private function init_flash() {
        if (!isset($_SESSION['wp_mvc_flash'])) {
            $_SESSION['wp_mvc_flash'] = array();
        }
    }

    public function refresh() {
        $location = $this->current_url();
        $this->redirect($location);
    }

    public function redirect($location, $status=302) {

        if (headers_sent()) {
            $html = '
                <script type="text/javascript">
                    window.location = "'.$location.'";
                </script>';
            echo $html;
        } else {
            wp_redirect($location, $status);
        }

        die();

    }

    public function current_url() {
        return $_SERVER['REQUEST_URI'];
    }
}