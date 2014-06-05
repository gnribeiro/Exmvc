<?php 

class  Category extends BaseModel{

    public $term_id;
    
    public $name;

    public $slug;

    public $taxonomy;

    public $description;

    public $parent;

    public $term_taxonomy_id;

    public $object_id;

    public $is_intro;
    
    public $post_content;

    public $post_title;

    public $ID;

    public $num_rows;

    public static function get_table_term_relationships(){
        global $wpdb;

        return $wpdb->term_relationships;
    }


    public static function get_table_term_taxonomy(){
        global $wpdb;

        return $wpdb->term_taxonomy;
    }

    public static function get_table_posts(){
        global $wpdb;

        return $wpdb->posts;
    }

    public static function is_intro($postID){
        $sql = "SELECT count(wp_posts.ID) as is_intro 
                FROM  wp_posts  
                INNER JOIN wp_term_relationships ON (wp_posts.ID = wp_term_relationships.object_id)
                INNER JOIN wp_term_taxonomy ON (wp_term_taxonomy.term_taxonomy_id = wp_term_relationships.term_taxonomy_id)  
                INNER JOIN wp_terms ON (wp_term_taxonomy.term_id = wp_terms.term_id) 
                WHERE wp_terms.name like \"intro\" AND wp_posts.ID = {$postID}";

        $is_inttro = self::query()->sql($sql);
        return $is_inttro[0]->is_intro;
    }

   
    public static function get_intro($ids = array()){
        if(!is_array($ids) || !count($ids))
            return ;

        $cat_ids               = implode(',' , $ids);
        $total                 = count($ids);
        $tb_posts              = self::get_table_posts();
        $tb_term_relationships = self::get_table_term_relationships(); 
        $tb_term_taxonomy      = self::get_table_term_taxonomy();
        $tb_term               = self::get_table();

        $sql = "SELECT  {$tb_posts}.ID, {$tb_posts}.post_title ,{$tb_posts}.post_content, {$tb_term}.name from  wp_posts  
               INNER JOIN {$tb_term_relationships} ON ({$tb_posts}.ID = {$tb_term_relationships}.object_id)
               INNER JOIN {$tb_term_taxonomy} ON ({$tb_term_taxonomy}.term_taxonomy_id = {$tb_term_relationships}.term_taxonomy_id)  
               INNER JOIN {$tb_term} ON ({$tb_term_taxonomy}.term_id = {$tb_term}.term_id) 
               WHERE ( ( SELECT COUNT(1) FROM {$tb_term_relationships}  inner join {$tb_term_taxonomy} on ({$tb_term_relationships}.term_taxonomy_id = {$tb_term_taxonomy}.term_taxonomy_id ) WHERE {$tb_term_taxonomy}.term_id IN ($cat_ids) AND object_id = {$tb_posts}.ID ) = {$total} ) 
               GROUP BY {$tb_posts}.ID";
              
        return self::query()->sql($sql);        
    }


    public static function get_posts_nointro($cat , $intro, $limit, $offset , &$total){
        $tb_posts              = self::get_table_posts();
        $tb_term_relationships = self::get_table_term_relationships(); 
        $tb_term_taxonomy      = self::get_table_term_taxonomy();
        $tb_term               = self::get_table();

        $sql = "SELECT SQL_CALC_FOUND_ROWS {$tb_posts}.ID, {$tb_posts}.post_title ,{$tb_posts}.post_content, {$tb_term}.name from  wp_posts  
               INNER JOIN {$tb_term_relationships} ON ({$tb_posts}.ID = {$tb_term_relationships}.object_id)
               INNER JOIN {$tb_term_taxonomy} ON ({$tb_term_taxonomy}.term_taxonomy_id = {$tb_term_relationships}.term_taxonomy_id)  
               INNER JOIN {$tb_term} ON ({$tb_term_taxonomy}.term_id = {$tb_term}.term_id) 
               WHERE (( SELECT COUNT(1) FROM {$tb_term_relationships}  inner join {$tb_term_taxonomy} on ({$tb_term_relationships}.term_taxonomy_id = 
                {$tb_term_taxonomy}.term_taxonomy_id ) WHERE {$tb_term_taxonomy}.term_id IN ($intro) AND object_id = {$tb_posts}.ID ) = 0 ) 
               AND {$tb_term_taxonomy}.term_id = $cat
               LIMIT {$offset} , {$limit}";
               
        $results = self::query()->sql($sql);
        $total   = self::query()->sql("SELECT FOUND_ROWS() as num_rows");
        $total   = $total[0]->num_rows;
        
        return $results;
    }


    public static function get_cat_post($cat_ids = FALSE){
        if($cat_ids === FALSE)
            return;

        if(is_array($cat_ids))
            $cat_ids = implode(',' , $cat_ids);

        $tb_posts              = self::get_table_posts();
        $tb_term_relationships = self::get_table_term_relationships();

        $sql = "SELECT  {$tb_posts}.ID, {$tb_posts}.post_content, {$tb_term_relationships}.term_taxonomy_id 
        FROM   {$tb_posts}  INNER JOIN {$tb_term_relationships} ON ({$tb_posts}.ID = {$tb_term_relationships}.object_id) 
        WHERE ( {$tb_term_relationships}.term_taxonomy_id IN ({$cat_ids}) ) AND {$tb_posts}.post_type = 'post' AND ({$tb_posts}.post_status = 'publish') 
        GROUP BY {$tb_posts}.ID 
        ORDER BY {$tb_posts}.post_date DESC 
        LIMIT 0, 10";

        return self::query()->sql($sql);        
    }


    public static function get_childs($parent = FALSE){
       if($parent  === FALSE)
            return;

        $tb_term_taxonomy      = self::get_table_term_taxonomy();
        $tb_term               = self::get_table();

        $sql = "SELECT  {$tb_term }.name, {$tb_term }.slug, {$tb_term }.term_id from {$tb_term} 
        INNER JOIN {$tb_term_taxonomy} ON ({$tb_term_taxonomy}.term_id = {$tb_term}.term_id)  
        WHERE {$tb_term_taxonomy}.parent = {$parent}";
        
        return self::query()->sql($sql);  
    }
    
    public static function get_childs_intro($intro ,  $parent = FALSE ){
        $children = self::get_childs($parent);
        $data  = array();
        if(count($children))  {
            foreach ($children as $key => $value) {
                $intros = self::get_intro(array($intro , $value->term_id));
               
                $data[$key]["post_content"] = (isset($intros[0]->post_content )) ? $intros[0]->post_content : '';
                $data[$key]["name"]    =  $value->name;
                $data[$key]["slug"]    = get_category_link( $value->term_id);
                $data[$key]["term_id"] = $value->term_id;
            }
        }  

       

      return $data;
    }

    public static function get_primary_key(){
        return 'term_id';
    }


    public static function get_table(){
        global $wpdb;

        return $wpdb->terms;
    }


    public static function get_searchable_fields(){
        return array('name', 'slug', 'term_id');
    }

}    