<?php

namespace MrAnyx\TinyDB;

class TinyDB{

	private $file;

    public function open($file){
    	if(!file_exists($file)){
    		throw new Exception("File doesn't exists");
    	}else{
    		$this->file = $file;
    	}
    }

    public function read(){
    	return file_get_contents($this->file);
    }
}
