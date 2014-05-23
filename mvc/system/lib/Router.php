<?php

class Router {
	const REGEX_KEY     = '<([a-zA-Z0-9_]++)>';
	
	const REGEX_SEGMENT = '[^/.,;?\n]++';
	const REGEX_ESCAPE  = '[.\+*?[^\]${}=!|]';
	
	protected $_regex;
	protected $_route_regex;
	protected static $_routes;
	protected $_uri;
	protected $_defaults;
	protected $default_action = "index";

	public function __construct( $uri = NULL , $regex = NULL  ){

		if ($uri === NULL) {
        	return;
   		}
 
    	if ( ! empty($regex)){
    	    $this->_regex = $regex;
    	}

	    $this->_uri = $uri;
 
    	$this->_route_regex = $this->_compile();
	}

	
	public static function all(){
		 return Router::$_routes;
	}

	public static function matches( $uri ){
		$routes = Router::$_routes;

		foreach ($routes as $key => $value) {
			
			if (  preg_match($value->_route_regex, $uri, $matches)){
				return $value->_regex ;
			}
		}
	}

	public static function get($name){
	    if ( ! isset(Router::$_routes[$name]))
	    {
	        throw new Exception('The requested route does not exist: :route');
	    }
	 
	    return Router::$_routes[$name];
	}
	

	public function matchesKhoana($uri){
	    if ( ! preg_match($this->_route_regex, $uri, $matches))
	        return FALSE;
	 
	    $params = array();
	    foreach ($matches as $key => $value)
	    {
	        if (is_int($key))
	        {
	            // Skip all unnamed keys
	            continue;
	        }
	 
	        // Set the value for all matched keys
	        $params[$key] = $value;
	    }
	 
	    foreach ($this->_defaults as $key => $value)
	    {
	        if ( ! isset($params[$key]) OR $params[$key] === '')
	        {
	            // Set default values for any key that was not matched
	            $params[$key] = $value;
	        }
	    }
	 
	    return $params;
	}


	public  function name($route){
	  return array_search($route, Router::$_routes);
	}


	public static function set($name, $uri, array $regex = NULL){
    	return Router::$_routes[$name] = new Router($uri, $regex);
	}


	protected function _compile(){
 		$regex = $this->_uri;
       	return '#^'.$regex.'$#uD';
	}

}