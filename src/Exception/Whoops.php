<?php 

namespace Phplite\Exception;
class Whoops{
    /**
     * 
     */
    private function __construct(){

    }
    public static function handle(){

        $whoops = new \Whoops\Run;
        $whoops->prependHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }
}

