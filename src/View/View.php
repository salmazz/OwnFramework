<?php 


namespace Phplite\View;

use Phplite\File\File;
use Exception;
use Jenssegers\Blade\Blade;
use Illuminate\Support\Facades\Storage;
use Phplite\Session\Session;

class View{
    /**
     * View Constructor 
     * 
     */
    private function __construct()
    {}
            /**
     * Render view file
     * @param array $data 
     * @return string
     * 
     */
    public function render($path,$data=[]){
        $errors = Session::flash('errros');
        $old= Session::flash('old');
        $data= array_merge($data,['errors'=>$errors,'old'=>$old]);
        return static::bladeRender($path,$data);
    }
  
    /**
     * render the view files using blade engine 
     * @param string $path
     * @param array $data
     * @return string 
     */
    public static function bladeRender($path, $data = []) {
      $blade = new Blade(File::path('views'), File::path('storage/cache'));
      return $blade->make($path, $data)->render();
  }
      /**
     * Render view file
     * @param array $data 
     * @return string
     * 
     */
    public static function viewRender($path,$data=[]){
       $path = 'views'. File::ds() . str_replace(['/','\\' ,'.'],File::ds(),$path) . '.php';
       if(! File::exist($path)){
        throw new Exception("the view file {$path} is not exists");
       }
       ob_start();
       extract($data);
       include File::path($path);
       $content = ob_get_contents();
       ob_end_clean();
       return $content;
    }
}