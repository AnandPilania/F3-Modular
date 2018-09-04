<?php

namespace Core\Controllers;

use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class ReloadrController {
	protected $list = array();

	public function init($app) {
		$root_path = base_path();
        $config = $app->get('reloadr');
        $filter = $config['filter'];

        if(!empty($dirs = $config['dirs']?:array())){
            foreach($dirs as $dir){
                $dir = $root_path.$dir;
                if(file_exists($dir)){
                    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)) as $file){
                        $this->filterExt($file, $filter);
                    }
                }
            }
        }

        if(!empty($files = $config['files']?:array())){
            foreach($files as $file){
                $file = $root_path.$file;
                if($file_exists($file)){
                    $this->filterExt($file, $filter);
                }
            }
        }

        json($this->list);
	}

	protected function filterExt($file, array $filter = []) {
        $except = (null !== $filter['except'] ? $filter['except'] : []);
        $accept = (null !== $filter['accept'] ? $filter['accept'] : []);

        if(!empty($except)){
            foreach($except as $ext){
                if(pathinfo($file, PATHINFO_EXTENSION) !== strtolower($ext)){
                    $this->list[] = filemtime($file);
                }
            }
        }

        if(!empty($accept)){
            foreach($accept as $ext){
                if(pathinfo($file, PATHINFO_EXTENSION) === strtolower($ext)){
                    $this->list[] = filemtime($file);
                }
            }
        }
    }
}