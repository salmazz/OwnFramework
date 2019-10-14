<?php 

namespace Phplite\Bootstrap;
use Phplite\Exception\Whoops;
use Phplite\Session\Session;
use Phplite\Cookie\Cookie;
use Phplite\Http\Server;
use Phplite\Http\Request;
use Phplite\File\File;
use Phplite\Router\Route;
use Phplite\Http\Response;

class App{
    private function __construct(){

    }
    public static function run(){

        // register  whoops 
        Whoops::handle();

        // start session 
        Session::start();
        // echo "<pre>";
        // print_r(Server::all());
        // echo "</pre>";
    //   echo Server::get('REQUEST_SCHEME');
       
 
         Request::handle();
           
          
         File::require_directory('routes');
        //  echo "<pre>";
        //   print_r(Route::allRoutes());
        //   echo "</pre>";

          $data =  Route::handle();
          Response::output($data);
          

    }
    

}