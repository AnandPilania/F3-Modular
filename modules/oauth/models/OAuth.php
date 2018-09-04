<?php

namespace OAuth\Models;

use Model;
use Bcrypt;
use DB\SQL\Schema;

class OAuth extends Model
{
    protected $table = 'oauth_users',
        $fields = array(
            'id' => array(
                'type' => Schema::DT_INT,
                ),
            'oauth' => array(
                'type' => Schema::DT_VARCHAR256,
                ),
            'uid' => array(
                'type' => Schema::DT_VARCHAR128,
                ),
            'name' => array(
                'type' => Schema::DT_VARCHAR128,
                ),
            'email' => array(
                'type' => Schema::DT_VARCHAR256,
                ),
            'first_name' => array(
                'type' => Schema::DT_VARCHAR256,
                ),
            'last_name' => array(
                'type' => Schema::DT_VARCHAR256,
                ),
            'gender' => array(
                'type' => Schema::DT_VARCHAR128,
                ),
            'picture' => array(
                'type' => Schema::DT_VARCHAR256,
                ),
            'date_created' => array(
                'type' => Schema::DT_TIMESTAMP,
                'default' => Schema::DF_CURRENT_TIMESTAMP
                ),
            'date_modified' => array(
                'type' => Schema::DT_TIMESTAMP,
                'default' => ''
                ),
        );
}