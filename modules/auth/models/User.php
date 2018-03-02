<?php

namespace Auth\Models;

use Bcrypt;
use DB\SQL\Schema;

class User extends Model
{
    protected $table = 'users',
        $fields = array(
            'first_name' => array(
                'type' => Schema::DT_VARCHAR128,
                ),
            'last_name' => array(
                'type' => Schema::DT_VARCHAR128,
                ),
            'email' => array(
                'type' => Schema::DT_VARCHAR128,
                ),
            'password' => array(
                'type' => Schema::DT_VARCHAR256,
                ),
            'is_activated' => array(
                'type' => Schema::DT_BOOLEAN,
                'default' => false
                ),
            'is_loggedin' => array(
                'type' => Schema::DT_BOOLEAN,
                'default' => false
                ),
            'api_token' => array(
                'has-one' => array('\Auth\Models\Token', 'user')
                ),
            'password_token' => array(
                'has-one' => array('\Auth\Models\PasswordReset', 'user')
                ),
            'activation_token' => array(
                'has-one' => array('\Auth\Models\Activation', 'user')
                ),
        );
    public function set_first_name($fName)
    {
  	    return ucfirst($fName);
    }
    public function set_last_name($lName)
    {
  	    return ucfirst($lName);
    }
    public function set_password($pswd)
    {
  	    return Bcrypt::instance()->hash($pswd);
    }
}