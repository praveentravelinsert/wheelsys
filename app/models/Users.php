<?php

use Phalcon\Mvc\Model;

class Users extends Model
{

	public $id;
	public $name;
	public $email;
	
	public function getSource() {
      return 'users';
   }
   
   public static function find($parameters = null) { 
      return parent::find($parameters);
   } 
   
   public static function findFirst($parameters = null) {
      return parent::findFirst($parameters);
   }   

}
