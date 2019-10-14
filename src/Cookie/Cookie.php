<?php 

namespace Phplite\Cookie;

class Cookie {
    /**
     * 
     * session construct 
     */
    private function __construct(){

    }

     /***
      * Set New Session
      * @param String @value
      */
    public static function set($key,$value){
        $expired = (1 * 365 * 24 * 60 * 60);
        setcookie($key,$value,$expired,'','/',false,true);
        return $value;
     }
     /**
      * 
      * check that the cookie has the key
      */
     public static function has($key){
      return isset($_COOKIE[$key]);
     }
     /**
      * get session
      * @param string $key
      * @return mixed
      */

      public static function get($key){
          return static::has($key) ? $_COOKIE[$key]:null;
      }
      
    /**
     * Remove Cookie by the given way 
     * @param string $key
     * @return void
     */
    public static function remove($key){
        unset($_COOKIE[$key]);
        setcookie($key,null,'-1','/');
    }
    /**
     * Return all Cookies 
     * @return array  
     */
    public static  function all(){
        return $_COOKIE;
    }
    /**
     * destroy the cookies  
     * return void
     *  
     * */ 
   
    public static function destroy(){
        foreach(cookie::all() as $key=> $value ){
            static::remove($key);
        }
    }

 
}