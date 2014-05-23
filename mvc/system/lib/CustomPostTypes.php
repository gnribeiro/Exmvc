<?php 

class CustomPostTypes{
    
    protected  $cpt           = array();
    protected  $adminSettings = array();
    protected  $ctfield       = array();
    protected  $categories    = array();
    

    public function __construct(){
        $this->get_customPosts();
        $adminSettings = array(
            'customPostTypes' => $this->adminSettings
        );

        $adminController = new AdminController($adminSettings);
        add_action('init', array($this, 'register_categories'));
    }


    protected function get_customPosts(){
        if($this->cpt = Helper::load_config('customPostTypes')){
           if(is_array($this->cpt)){
                foreach ($this->cpt as $key => $value) {
                    if(is_array($value)){
                        $value['fieldBlocks']  = $this->get_customField($key);
                        $this->categories[]    = $this->get_categories($key);  
                        $this->adminSettings[] = $value;
                    }
                }
            } 
        }
    }


    protected function get_customField($key){
        if($this->ctfield = Helper::load_config('customField')){
             if(array_key_exists ($key , $this->ctfield )){
                return $this->ctfield[$key];
            }           
        }
    }


    protected function register_category($name, $cpt,  $rewrite){
        $args = array(
            'labels' => array (
                'name'              => ucfirst($name) . ' Categories',
                'singular_name'     => ucfirst($name) . ' Categories',
                'search_items'      => 'Search '. ucfirst($name) .' Categories',
                'popular_items'     => 'Popular '. ucfirst($name) .' Categories',
                'all_items'         => 'All '. ucfirst($name) .' Categories',
                'parent_item'       => 'Parent '. ucfirst($name) .' Category',
                'parent_item_colon' => 'Parent '. ucfirst($name) .' Category:',
                'edit_item'         => 'Edit '. ucfirst($name) .' Category',
                'update_item'       => 'Update '. ucfirst($name) .' Category',
                'add_new_item'      => 'Add New '. ucfirst($name) .' Category',
                'new_item_name'     => 'New '. ucfirst($name) .' Category',
            ),
            'hierarchical'  => true,
            'show_ui'       => true,
            'show_tagcloud' => true,
            'rewrite'       => array('slug' => 'galleries'),
            'public'        => true
            
        );

        register_taxonomy($name, $cpt, $args);
    }


    protected function get_categories($key){
        if($category = Helper::load_config('categories') ){
            if(array_key_exists ($key ,  $category )){
                $category[$key]['cpt'] = $key;
                return $category[$key];
            }
        }
    }
    

    public function register_categories(){
        foreach ($this->categories as $key => $value) {
            if( !isset($value['rewrite']) && 
                !isset($value['name'])  &&
                !isset($value['cpt'])
            ) continue;

           $this->register_category($value['name'], $value['cpt'],  $value['rewrite']);
        }
    }

}