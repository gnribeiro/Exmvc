<?php

class Controller_Category extends Controller {
	

	private $introID; 

	public function __construct(){
		parent::__construct();
        
        $introID = array(
        	'en' => 32,
        	'pt' => 41
        );
  		
  		$this->introID = $introID[pll_current_language()]; 
	}

	public function lista(){

	}



	public function produtos(){

		if(Helper::get_wp_template() == "category"){
			$uri_segments = explode("/" , $this->uri);
			$catgory      = end($uri_segments);
			$category     = get_category_by_slug( $catgory );
			$offset       = (get_query_var('paged')) ? get_query_var('paged') - 1 : 0;  
			$limit        = 1;
			$total        = 0;
			
			$this->view->lists = false;
			
			
			$this->view->intro = Category::get_intro(array($category->term_id , $this->introID));
			
			if(count($uri_segments)>=3){
				$this->view->list_posts = Category::get_posts_nointro($category->term_id , $this->introID, $limit, $offset , $total); 				
				$this->view->lists      = true;
				$this->view->pagination = $this->pagination($total);
			}
			else{
				$this->view->childrens = Category::get_childs_intro($this->introID , $category->term_id);
			}
			
		
			$content = $this->view->render($this->defauld_view);
	        //$content = $this->view->render('produtos/category2');
	        $this->content($content);
		}
		else{
			echo "s6s";
			global $post;
			echo var_dump($post->post_name );
			$content = 'single';
        	$this->content($content);
		}
		

		
	}

	public function lista2(){
	   
    	$content = $this->view->render($this->defauld_view);
        $this->content($content);
	}
}