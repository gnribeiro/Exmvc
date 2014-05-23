<?php

class ClassAutoloader {
    
    public function __construct($prepend = false) {

        if (version_compare(phpversion(), '5.3.0', '>=')) {
            spl_autoload_register(array(__CLASS__, 'autoload'), true, $prepend);
        } 
        else {
            spl_autoload_register(array(__CLASS__, 'autoload'));
        }
    }


    public  function autoload($class){
        if (is_file($file = SYSPATH . 'lib/' .str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
            @require_once $file;
        }
        elseif (is_file($file = APPPATH . 'lib/' .str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
            @require_once $file;
        }
        elseif (is_file($file = APPPATH . 'controllers/'.str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
            @require_once $file;
        }
        elseif (is_file($file = APPPATH . 'models/'.str_replace(array('_', "\0"), array('/', ''), $class).'.php')) {
            @require_once $file;
        }
    }
}