<?php 

namespace Phplite\Router;

use Exception;
use BadFunctionCallException;
use Phplite\Http\Request;
use ReflectionClass;
use ReflectionException;
use Psr\Log\InvalidArgumentException;

class Route{
    /**
     * Route Container
     * @var array $routes
     */
    private static $routes = [];

    /**
     * middleware 
     * 
     * @var String $middleware 
     * 
     */
    private static $middleware;
      /**
     * Prefix 
     * 
     * @var String $prefix 
     * 
     */
    private static $prefix;
    /**
     * Route Constructor 
     * @return void
     */
    private function __construct(){

    }
    /**
     * Add Route 
     * @param string $method 
     * @param string $uri
     * @param string $callback
     */
    private static function add($methods,$uri,$callback){
      $uri= trim($uri,'/');
      $uri = rtrim(static::$prefix . '/' . $uri );  
      $uri= $uri?: '/';
      foreach(explode('|', $methods)as $method){
        static::$routes[]=[
          'uri'=>$uri,
          'callback'=>$callback,
          'method'=>$method,
          'middleware'=> static::$middleware,

        ];
      } 
    }
    /***
     * add new get route 
     * @param string $uri
     * @param object|callback $callback
     */
    public static function get($uri,$callback){
      static::add('GET',$uri,$callback);

    }
       /***
     * add new post route 
     * @param string $uri
     * @param object|callback $callback
     */
    public static function post($uri,$callback){
      static::add('POST',$uri,$callback);
      
    }
       /***
     * add new any route 
     * @param string $uri
     * @param object|callback $callback
     */
    public static function any($uri,$callback){
      static::add('POST',$uri,$callback);
      
    }
    
   
    /**
     * set prefix for routing
     * @param string $prefix
     * @param string $callback
     * 
     */

     public static function prefix($prefix,$callback){
       $parent_prefix = static::$prefix;
       static::$prefix .= '/' .trim($prefix,'/');
       if(is_callable($callback)){
         call_user_func($callback);
       }else {
         throw new BadFunctionCallException("provide valid callback");

       }
       static::$prefix = $parent_prefix;
     }

     /**
     * set prefix for routing
     * @param string $prefix
     * @param string $callback
     * 
     */

    public static function middleware($middleware,$callback){
      $parent_middleware = static::$middleware;
      static::$middleware .= '|' .trim($middleware,'|');
      if(is_callable($callback)){
        call_user_func($callback);
      }else {
        throw new BadFunctionCallException("provide valid callback");

      }
      static::$middleware = $parent_middleware;
    }


    // public static function allRoutes(){
    //   return static::$routes;
    // }
    /**
     * Handle The Request and match the routes 
     * @return mixed
     * 
     */
    public static function handle(){
      $uri = Request::url();
      foreach(static::$routes  as $route){
        $matched=true;
        $route['uri'] = preg_replace('/\/{(.*?)}/','/(.*?)',$route['uri']);
        $route['uri'] = '#^' . $route['uri'] . '$#';
        if(preg_match($route['uri'],$uri,$matches)){
          array_shift($matches);
          $params= array_values($matches);
          foreach($params as $param){
            if(strpos($param,'/')){
              $matched=false;
            }
          }
          
          if($route['method'] != Request::method()){
            $matched = false;
          }
          if($matched == true ){
           return static::invoke($route,$params);
          }
        }
      }
      return View::render('error 404');
    }

    /**
     * invoke the route 
     * @param array $route
     * @param array $params 
     * 
     */
    public static  function invoke($route,$params=[]){
      static::exceuteMiddleware($route);

       $callback = $route['callback'];
       if(is_callable($callback)){
         return call_user_func_array($callback,$params);
       }elseif( strpos($callback,'@')!== false ) {
        list($controller,$method ) = explode('@',$callback);
        $controller = 'App\Controllers\\' . $controller;
        if(class_exists($controller)){
          $object = new $controller;
      
        if(method_exists($object,$method)){
          return call_user_func_array([$object,$method],$params);
        }else {
          throw new BadFunctionCallException("the method " . $method . "is not exists at " .$controller);
        }
      }else {
        throw new ReflectionException("the class " . $controller . "  is not found ");
      }
      
       }else {
        throw new InvalidArgumentException("provide valid callback function");
      }
    }

    /**
     * Execute Middleware
     * @param array $route
     * 
     */
    public static function exceuteMiddleware($route){
        foreach(explode('|',$route['middleware']) as $middleware ){
          if($middleware != ''){
            $middleware = 'App\Middleware\\' . $middleware;
            if(class_exists($middleware)){
              $object  = new $middleware; 
              return call_user_func_array([$object,'handle'] ,[]);
            }else {
              throw new ReflectionException("class" . $middleware . " is not found");
            }
          }      
        }
    }
    
}
