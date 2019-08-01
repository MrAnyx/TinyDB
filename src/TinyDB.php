<?php

namespace MrAnyx\TinyDB;
use Exception;


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
        if(!file_exists($this->file)){
            throw new Exception("File doesn't exists");
        }else{
            if(pathinfo($this->file)['extension'] != "json"){
                throw new Exception("File not supported (Allowed : Json");
            }else{
                return file_get_contents($this->file);
            }
        }
    	
    }
}
