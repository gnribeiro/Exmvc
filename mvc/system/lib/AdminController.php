<?php
class AdminController {
    private $settings;
  
    public function __construct($settings = false) {
        $this->settings = $settings;
        add_action('init', array($this, 'registerPostTypes'));
        add_action('init', array($this, 'addMetaBoxes'));
        add_action('after_setup_theme', array($this, 'addThemeSupport'));
        add_action('admin_enqueue_scripts', array($this, 'addStyles'));
        add_action('admin_print_scripts', array($this, 'loadScripts'));
    }

    public function registerPostTypes() {
      
        $customPostTypes = $this->getCustomPostTypesFromSettings();
    
        foreach ($customPostTypes as $customPost) {
            if (!isset($customPost['name'])) {
                continue;
            } 
            else {
                $name = $customPost['name'];
            }
          
            if (!isset($customPost['displayName'])) {
                $displayName = $name;
            } 
            else {
                $displayName = $customPost['displayName'];
            }
          
            if (!isset($customPost['pluralDisplayName'])) {
                $pluralDisplayName = $name . "s";
            }
            else {
                $pluralDisplayName = $customPost['pluralDisplayName'];
            }
          
            if (!isset($customPost['supports'])) {
                $supports = NULL;
            }    
            else {
                $supports = $customPost['supports'];
            }
          
            $this->registerPostType($name, $displayName, $pluralDisplayName, $supports);
        }
    }


    public function addMetaBoxes() {
        if (!is_admin()) {
          return;
        }
    
        $customPostTypes = $this->getCustomPostTypesFromSettings();
    
        foreach($customPostTypes as $customPostType) {
            if ( (!isset($customPostType['name'], $customPostType['fieldBlocks'])) || 
                 (!is_array($customPostType['fieldBlocks'])) || 
                 (count($customPostType['fieldBlocks']) == 0)) 
                continue;
        
            WPAlchemyHelpers::setupFieldBlocks($customPostType['name'], $customPostType['fieldBlocks']);
        }
    
        $customPages = $this->getCustomPagesFromSettings();

        foreach($customPages as $customPage) {
            if ((!isset($customPage['name'], $customPage['fieldBlocks'], $customPage['pageId'])) || (!is_array($customPage['fieldBlocks'])) || (count($customPage['fieldBlocks']) == 0) ) 
                continue;
            WPAlchemyHelpers::setupFieldBlocksForPage($customPage['pageId'], $customPage['name'], $customPage['fieldBlocks']);
        }
    }


    public function loadScripts() {
        wp_enqueue_script('jquery.wpImageUpload', THEMEURL . 'mvc/system/vendor/js/jquery.wpimageupload.js', array('jquery','media-upload','thickbox'));
        wp_enqueue_script('my-admin',             THEMEURL . 'mvc/system/vendor/js/admin.js', array('jquery', 'jquery.wpImageUpload'));
    }
  

    public function addThemeSupport() {
      add_theme_support( 'post-thumbnails' ); 
        //add_theme_support('post-thumbnails', $this->getCustomPostsThatRequirePostThumbnailsSupportFromSettings());
    }

        
    public function addStyles() {
        wp_register_style('my_meta_css', THEMEURL . 'mvc/system/lib/vendor/styles/admin.css');
        wp_enqueue_style('my_meta_css');
    }

    private function registerPostType($customPostTypeName, $displayName, $pluralDisplayName, $supports = NULL) {
    
        if ($supports == NULL) {
          $supports = array('title', 'editor', 'thumbnail', 'tags');
        }
    
        $labels = array(
          'name'               => ucfirst($pluralDisplayName),
          'singular_name'      => ucfirst($displayName),
          'add_new'            => 'Add '.ucfirst($displayName),
          'all_items'          => ucfirst($pluralDisplayName),
          'add_new_item'       => 'Add new '.ucfirst($displayName),
          'edit_item'          => 'Edit '.ucfirst($displayName),
          'new_item'           => 'New '.ucfirst($displayName),
          'view_item'          => 'View '.ucfirst($displayName),
          'search_items'       => 'Search '.ucfirst($pluralDisplayName),
          'not_found'          => 'No '.$pluralDisplayName.' found',
          'not_found_in_trash' => 'No '.$pluralDisplayName.' found in trash',
          'menu_name'          => ucfirst($pluralDisplayName)
        );
    
        $args = array(
          'labels'        => $labels,
          'public'        => true,
          'menu_position' => 5,
          'supports'      => $supports,
          'has_archive'   => true,
          'show_ui'       => true,
          'rewrite'       => array(
              'slug'  => $pluralDisplayName
            )
          );
    
        register_post_type($customPostTypeName, $args );   
    }

    private function getCustomPostsThatRequirePostThumbnailsSupportFromSettings() {

        $customPostTypes = $this->getCustomPostTypesFromSettings();
        $customPostsSupportingPostThumbnails = array();
    
        foreach ($customPostTypes as $customPostType) {
          if ( (isset($customPostType['enablePostThumbnailSupport']) && (isset($customPostType['name'])) && ($customPostType['enablePostThumbnailSupport']))) {
            array_push($customPostsSupportingPostThumbnails, $customPostType['name']);
          }
        }
    
        if (!empty($this->settings['thumbnailsInStandardPosts']) && $this->settings['thumbnailsInStandardPosts'] == true) {
          array_push($customPostsSupportingPostThumbnails, 'post');
        }
    
        return $customPostsSupportingPostThumbnails;
    }

    private function getCustomPostTypesFromSettings() {
        if (!isset($this->settings) || !isset($this->settings['customPostTypes'])) {
            return array();
        } 
        else {
            return $this->settings['customPostTypes'];
        }
    }
  
    private function getCustomPagesFromSettings() {
        if (!isset($this->settings) || !isset($this->settings['customPages'])) {
            return array();
        } 
        else {
            return $this->settings['customPages'];
        }
    }
}


?>