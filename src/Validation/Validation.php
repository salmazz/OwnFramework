<?php 


namespace Phplite\Validation;

use Phplite\Http\Request;
use Rakit\Validation\Validator;

class Validate{
/**
 * validation constructor
 * 
 * @param array $rules
 * @param bool $json
 * @return mixed 
 *  */ 
public static function validate(Array $rules,$json){
  
$validator = new Validator;

// make it
$validation = $validator->validate($_POST + $_FILES,$rules);
$errors = $validation->errors();

if ($validation->fails()) {
    // handling errors
    if($json){
        return ['errors' => $errors->firstOfAll()];
    }else {
        Session::get('errors',$errors);
        Session::get('old',Request::all());
        return Url::redirect(URL::previous());
    }
}
}




}