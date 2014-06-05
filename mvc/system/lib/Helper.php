<?php 
class Helper {
    public static function load_file($file) {
        $file = $file . EXT;
        if(is_file($file))
            return include $file;
    }

    public static function load_config($file) {
        $file = APPPATH . 'config/' . $file;
        return self::load_file($file);
    }

    public static function lang_category_slug($slug , $lang){
       $cat     = get_category_by_slug( $slug );
       $term_id = $cat->term_id;

       $id = pll_get_term($term_id, $lang);

       $cat = get_category($id);

       return  $cat->slug;
    }

    
    public static function lang_post_slug($slug , $lang){
        global $post;
        
        if($id = pll_get_post($post->ID, $lang)){
            return self::postSlug_by_ID($id);
       }
       else{
        return $slug;
       }
    }


    public static function get_uri(){
        return rtrim(preg_replace(array('@\?.*$@' , '#^/#' , '@page/[\d]+@'), array('' , '', ''), $_SERVER['REQUEST_URI']) , '/');
    }


    public static function lang_page_slug($slug , $lang){
 
       if($id  = pll_get_post( self::pageID_by_slug( $slug ), $lang)){
            return self::pageSlug_by_ID($id);
        }
        else{
            return $slug;
        }
    }

    public static function is_categorie($slug){
      global  $wpdb;

      $slug = esc_sql($slug);

      return $wpdb->get_var("SELECT count({$wpdb->terms}.term_id) from {$wpdb->terms} 
          LEFT JOIN {$wpdb->term_taxonomy} on ({$wpdb->term_taxonomy}.term_id  = {$wpdb->terms}.term_id) 
          WHERE  {$wpdb->terms}.slug = '{$slug}' AND {$wpdb->term_taxonomy}.taxonomy LIKE 'category' ");
    } 


    public static function is_post($slug){
      global $wpdb;

      $slug = esc_sql($slug);

      $post_type =  $wpdb->get_var( "SELECT post_type FROM {$wpdb->posts} WHERE  post_name like '{$slug}' " );
      
      return ($post_type === 'post') ? true : false;
    }

    
    public static function postID_by_slug($slug){
      global $wpdb;

      $slug = esc_sql($slug);
  
      return $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE  post_name like '{$slug}' and post_type like 'post' " );
    } 


    public static function pageID_by_slug($slug){
      global $wpdb;

      $slug = esc_sql($slug);

      return $wpdb->get_var( "SELECT ID FROM {$wpdb->posts} WHERE  post_name like '{$slug}' and post_type like 'page' " );
    } 

    public static function postSlug_by_ID($id){
      global $wpdb;

      $slug = esc_sql($id);

      return $wpdb->get_var( "SELECT post_name FROM {$wpdb->posts} WHERE  ID = {$id} and post_type like 'post' " );
    } 

    public static function pageSlug_by_ID($id){
      global $wpdb;

      $slug = esc_sql($id);

      return $wpdb->get_var( "SELECT post_name FROM {$wpdb->posts} WHERE  ID = {$id} and post_type like 'page' " );
    }

    public static function siteInfo() {
        return array(
          'blog_title'  => self::getSiteTitle(),
          'name'        => get_bloginfo('name'),
          'description' => get_bloginfo('description'),
          'admin_email' => get_bloginfo('admin_email'),

          'url'   => get_bloginfo('url'),
          'wpurl' => get_bloginfo('wpurl'),

          'stylesheet_directory' => get_bloginfo('stylesheet_directory'),
          'stylesheet_url'       => get_bloginfo('stylesheet_url'),
          'template_directory'   => get_bloginfo('template_directory'),
          'template_url'         => get_bloginfo('template_url'),

          'atom_url'     => get_bloginfo('atom_url'),
          'rss2_url'     => get_bloginfo('rss2_url'),
          'rss_url'      => get_bloginfo('rss_url'),
          'pingback_url' => get_bloginfo('pingback_url'),
          'rdf_url'      => get_bloginfo('rdf_url'),

          'comments_atom_url' => get_bloginfo('comments_atom_url'),
          'comments_rss2_url' => get_bloginfo('comments_rss2_url'),

          'charset'        => get_bloginfo('charset'),
          'html_type'      => get_bloginfo('html_type'),
          'language'       => get_bloginfo('language'),
          'text_direction' => get_bloginfo('text_direction'),
          'version'        => get_bloginfo('version'),
          
          'is_user_logged_in' => is_user_logged_in()
        );
    }

    public static function getSiteTitle() {
        if (is_home()) {
          return get_bloginfo('name');
        } 
        else {
          return wp_title("-", false, "right")." ".get_bloginfo('name');
        }
    }
    
    public static function get_wp_template(){
        if( is_post_type_archive()){
            return 'postTypeArchive';
        }
        elseif(is_category()){
            return 'category';
        }
        elseif(is_attachment()){
            return 'attachment';
        }
        elseif(is_page()){
            return 'page';
        }
        elseif(is_single() && !is_attachment()){
            return 'single';
        }
        elseif(is_home() || is_front_page() ){
            return 'frontpage';
        }
        elseif(is_search()){
            return 'search';
        }

        elseif( is_tag()){
            return 'tag';
        }
        elseif( is_archive()){
            return 'archive';
        }
        elseif( is_404()){
            return '404';    
        }
    }

}



?>