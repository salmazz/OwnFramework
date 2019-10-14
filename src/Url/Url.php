<?php 

namespace Phplite\Url;

use Phplite\Http\Request;
use Phplite\Http\Server;

class Url{
    /**
     * Url Constructor
     * 
     * 
     */
    private static function __contruct(){

    }
    /**
     * get path 
     * @return string $path 
     */
    public static function path($path){
        return Request::baseUrl() . '/' .trim($path,'/');
    }
    /**
     * previous url
     * @return string
     * 
     */
    public static function previous(){
        return Server::get('HTTP_REFERER');
    }
    public static function redirect($path){
         header('location: '.$path);
         exit();
    }
}