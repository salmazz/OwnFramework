<?php 


namespace Phplite\Http;

class Server{
/**
 * Server Constructor
 * 
 */

 public function __construct(){
    
 }
 /**
  * 
  * Get all server data
  */
 public static function all(){
  return $_SERVER;
 }
 /***
  * check that the server has($key)
  * 
  * @return bool
  */
 public static function has($key){
     return isset($_SERVER[$key]);
 }

 /**
  * Get The Value From Server By the given key
  * @parms string $key
  * @return String Value
  */
  public static function get($key){
      return static::has($key) ? $_SERVER[$key] : null;
  }

  /**
   * get path info for paths 
   */
  public static function path_info($path){
      return pathinfo($path);
  }
 
}