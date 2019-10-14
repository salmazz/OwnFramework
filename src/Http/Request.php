<?php 
namespace Phplite\Http;

class Request{
    /***
     * scriptname
     * @var scriptname
     */
    private static $scriptName;

    /***
     * Base UrL
     * @var base_url
     */
    private static $base_url;
     /***
     *  UrL
     * @var $url
     */
    private static $url;
      /***
     *  Full
     * @var $full_url
     */
    private static $full_url;
    /***
     *  QueryString
     * @var $query
     */
    private static $query_string;
    /**
     * Request Construct
     * @return Void
     */
    private function __contruct(){
    
    }
    /**
     * handle the request 
     * @return void
     */

    public static function handle(){
        static::$scriptName = str_replace('\\','',dirname(Server::get('SCRIPT_NAME')));
        static::setBaseUrl();
        static::setUrl();
    }
    /**
     * set base url 
     * @return void 
     */
    private static function setBaseUrl(){
    $protocol = Server::get('REQUEST_SCHEME').'://';
    $host=Server::get('HTTP_HOST');
    $script_name = static::$scriptName;
    static::$base_url = $protocol . $host . $script_name;
    } 
    /**
     * set  url 
     * @return void 
     */
    private static function setUrl(){
        $reqest_uri = urldecode(Server::get('REQUEST_URI'));
        $reqest_uri = rtrim(preg_replace("# ^". static::$scriptName.'#','',$reqest_uri),'/');
        $query_string= '';
        static::$full_url=$reqest_uri;
        if(strpos($reqest_uri,'?')!== false){
         list($reqest_uri,$query_string)= explode('?',$reqest_uri);
        }

    static::$url = $reqest_uri;
    static::$query_string=$query_string;
    } 

    public static function baseUrl(){
        return static::$base_url;
    }
    public static function url(){
        return static::$url;
    }
    public static function query_string(){
        return static::$query_string;
    }
    public static function full_url(){
        return static::$full_url;
    }
    /**
     * get request method 
     * @return string
     */
    public static function method(){
        return Server::get('REQUEST_METHOD');
    }
    /**
     * 
     * check if the get the key and the value
     *  @param string $key
     *  @param array $type  
     *  @return bool    
     */
    public static function has($type,$key){
        return array_key_exists($key,$type);
         
    }
     /**
     * 
     * get the value from the request 
     *  @param string $key
     *  @param array $type  
     *  @return bool    
     */
    public static function value($key, array $type=null){
        $type  = isset($type) ? $type : $_REQUEST;
        return static::has($type,$key) ? $type[$key] : null ;
         
    }
    /**
     * Get Value from get request 
     * @params String $key
     * @return string value
     */

     public static function get($key){
         return static::value($key,$_GET);
     }
     /**
     * Get Value from post request 
     * @params String $key
     * @return string value
     */

    public static function post($key){
        return static::value($key,$_POST);
    }
    /**
     * set value for request by the given key
     * @param string $key 
     * @param string $value 
     * @return string $key 
     */
    public static function set($key,$value){
     $_REQUEST[$key] = $value;
     $_POST[$key]=$value;
     $_GET[$key] = $value;
    }
    /**
     * get perivous request value 
     * @return string 
     */
    public static function previous(){
        return Server::get('HTTP_REFERER');
    }
    /**
     * Get all requests 
     * @return 
     */
    public static function all(){
        return $_REQUEST;
        
    }


}