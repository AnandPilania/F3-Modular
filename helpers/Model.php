<?php

use DB\Cortex;
//use DB\SoftErase;
use DB\SQL\Schema;

abstract class Model extends Cortex
{
    //use SoftErase;

    public $f3, $db = 'DB';
    public $fieldConf = array(
        'created_at' => array(
            'type' => Schema::DT_TIMESTAMP,
            'default' => Schema::DF_CURRENT_TIMESTAMP
            ),
        'updated_at' => array(
            'type' => Schema::DT_TIMESTAMP,
            'default' => '0-0-0 0:0:0'
            )
        );

    public function __construct()
    {
        if (property_exists($this, 'fields')) {
            $this->fieldConf = array_merge($this->fields, $this->fieldConf);
        }

        parent::__construct();

        $this->f3 = Base::instance();

        $onloadHandler = function() {
            if(property_exists($this, 'guarded')) {
                foreach($this->guarded as $guard) {
                    unset($guard);
                }
            }
        };
        $this->onload($onloadHandler);
    }
    public function update()
    {
        $this->touch('updated_at');
        return $this;
    }
    public function save()
    {
        $app = App::instance();
        if(array_key_exists('user_id', $this->fieldConf) && !$this->user_id){
            $this->user_id = $app->user()->id?:$app->user()->_id;
        }
		if(array_key_exists('token', $this->fieldConf)) {
            $this->token = generateToken();
        }
        if(array_key_exists('expires_at', $this->fieldConf)) {
            $this->expires_at = generateExpiryDate(24);
        }
        return parent::save();
    }
}
