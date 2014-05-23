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
        if(is_single()){
            return 'single';
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
        elseif(is_post_type_archive()){
            return 'postTypeArchive';
        }
        elseif(is_front_page()){
            return 'frontpage';
        }
        elseif(is_search()){
            return 'search';
        }
        elseif(is_home()){
            return 'home';
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