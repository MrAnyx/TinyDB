<?php

namespace MrAnyx\TinyDB;

class TinyDB{

	private $file;

    public function open($file){

    	if(!file_exists($file)){
    		throw new Exception("File doesn't exists");
    	}else{
            if(pathinfo($file)['extension'] != "json"){
                throw new Exception("File not supported (Allowed : Json");
            }else{
                $this->file = $file;
            }
    	}
    }

    public function read(){
    	return file_get_contents($this->file);
    }
}
