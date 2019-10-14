<?php 

namespace Phplite\Http;
class Response {
/**
 * Response Constructor
 * 
 */
private function __construct(){

}
/**
 * Return Json Response 
 * @param mixed 
 * 
 */
public  static  function json($data){
    return json_encode($data);
   
   }
/**
 * output data
 * @param mixed $date
 * 
 */
public static function output($data){
    if(!$data ){return ;}
    if(! is_string($data)){
        $data =static::json($data);
    }
    echo $data;
}


}

