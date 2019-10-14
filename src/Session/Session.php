<?php 

namespace Phplite\Session;

class Session {
    /**
     * 
     * session construct 
     */
    private function __construct(){

    }
    /**
     *  Session Start
     */

    public static function start(){
         if(!session_id()){
             ini_set('session.use_only_cookie',1);
             session_start();
         }
     }

     /***
      * Set New Session
      * @param String @value
      */
    public static function set($key,$value){
         $_SESSION[$key] = $value;
         return $value;
     }
     /**
      * 
      * check that the session has the key
      */
     public static function has($key){
      return isset($_SESSION[$key]);
     }
     /**
      * get session
      * @param string $key
      * @return mixed
      */

      public static function get($key){
          return static::has($key) ? $_SESSION[$key]:null;
      }
      
    /**
     * Remove Session by the given way 
     * @param string $key
     * @return void
     */
    public static function remove($key){
        unset($_SESSION[$key]);
    }
    /**
     * Return all Sessions 
     * @return array  
     */
    public static  function all(){
        return $_SESSION;
    }
    /**
     * destroy the session 
     * return void
     *  
     * */ 
   
    public static function destroy(){
        foreach(session::all() as $key=> $value ){
            static::remove($key);
        }
    }
    /**
     * get flash session 
     * @parms string $key
     * @return string $value
     * 
     */

     public static function flash($key){
        $value = null;
        if(static::has($key)){
            $value=static::get($key);
            static::remove($key);
        }
        return $value;
     }
 
}