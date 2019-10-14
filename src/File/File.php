<?php 
namespace Phplite\File;

class File{
  /**
   * File Constructor 
   * @return void
   */

   private function __construct(){
    
   }
   /**
    * Root Path 
    * @return string
    */
   public static function root(){
       return ROOT;

   }
   /**
    * Directroy Sperator
    * @return string
    */
   public static function ds(){
       return DS;

   }
   /**
    * Get File Root Path
    * @param String $path
    * @return string $path
    */
    public static function path($path){
        $path= static::root() . static::ds() . trim($path,'/');
        $path = str_replace(['/','\\'],static::ds(),$path);
        return $path;
    }
    /**
     * Check if the file exists 
     * @var String $path
     * @return bool 
     */
    public static function exist($path){
        return file_exists(static::path($path));
    }
       /**
     * Require file 
     * @var String $path
     * @return mixed  
     */
    public static function require_file($path){
       if(static::exist($path)){
           return require_once static::path($path);
       }
    }
          /**
     * include  file 
     * @var String $path
     * @return mixed  
     */
    public static function include_file($path){
        if(static::exist($path)){
            return include_once static::path($path);
        }
     }
     /**
      * Require Directory 
      * @param string $path
      * @return mixed
      * 
      */
     public static function require_directory($path){
       $files =   array_diff(scandir(static::path($path)),['.','..']);
        foreach($files as $file ){
            $file_path = $path . static::ds() . $file;
            if(static::exist($file_path)){
                static::require_file($file_path);
            }
        }
     }
}