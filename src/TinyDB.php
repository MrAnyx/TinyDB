<?php

namespace MrAnyx\TinyDB;
use Exception;

class TinyDB{

    private $file;

    // initialise l'attribut file
    public function open(string $file){
        if(!file_exists($file)){
            throw new Exception("File doesn't exists");
        }else{
            if(pathinfo($file)['extension'] != "json"){
                throw new Exception("File not supported (Allowed : Json)");
            }else{
                $this->file = $file;
            }
        }
    }


    // affiche le contenu du fichier en array
    public function toArray(){
        if(empty($this->file)){
            throw new Exception("Call 'open' first before calling any functions");
        }else{
            return json_decode(file_get_contents($this->file), true);
        }
        
    }


    // affiche le contenu du fichier en objet
    public function toObject(){
        if(empty($this->file)){
            throw new Exception("Call 'open' first before calling any functions");
        }else{
            return json_decode(file_get_contents($this->file), false);
        }
    }


    // affiche le contenu du fichier en string
    public function toString(){
        if(empty($this->file)){
            throw new Exception("Call 'open' first before calling any functions");
        }else{
            return file_get_contents($this->file);
        }
    }

    // Ajoute UN SEUL element
    public function writeOne(string $table, array $liste){
        if(empty($this->file)){
            throw new Exception("Call 'open' first before calling any functions");
        }else{
            $json = json_decode(file_get_contents($this->file), true);

            if(array_key_exists($table, $json)){
                $fichier = fopen($this->file, "w");

                array_push($json[$table], $liste);

                fwrite($fichier, json_encode($json, JSON_PRETTY_PRINT));
                fclose($fichier);
            }else{
                throw new Exception("table ".$table." doesn't exists");
            }
        }
        
    }

    // ajouter PLUSIEURS elements
    public function writeMany(string $table, array $liste){
        if(empty($this->file)){
            throw new Exception("Call 'open' first before calling any functions");
        }else{
            $json = json_decode(file_get_contents($this->file), true);

            if(array_key_exists($table, $json)){
                $fichier = fopen($this->file, "w");

                foreach ($liste as $value) {
                    array_push($json[$table], $value);
                }

                fwrite($fichier, json_encode($json, JSON_PRETTY_PRINT));
                fclose($fichier);
            }else{
                throw new Exception("table ".$table." doesn't exists");
            }
        }
    
    }


    // création d'une nouvelle table
    public function createTable(string $name){
        if(empty($this->file)){
            throw new Exception("Call 'open' first before calling functions");
        }else{

            $json = json_decode(file_get_contents($this->file), true);

            if(array_key_exists($name, $json)){
                throw new Exception("This table already exists");
            }else if(empty($name)){
                throw new Exception("Empty name are not allowed");
            }else{
                $fichier = fopen($this->file, "w");

                $json[$name] = array();

                fwrite($fichier, json_encode($json, JSON_PRETTY_PRINT));
                fclose($fichier);
            }
        }
    }


    // initialise le fichier s'il est vide
    public function init($default){
        if(empty($this->file)){
            throw new Exception("Call 'open' first before calling any functions");
        }else{
            if(empty(file_get_contents($this->file))){
                $fichier = fopen($this->file, "w");
                fwrite($fichier, json_encode($default, JSON_PRETTY_PRINT));
                fclose($fichier);
            }
        }
    }


    public function get(string $table){
        if(empty($this->file)){
            throw new Exception("Call 'open' first before calling any reading functions");
        }else{
            if(empty($table)){
                throw new Exception("Please, specify a table");
            }else{
                $json = json_decode(file_get_contents($this->file), true);
                return $json[$table];
            }
            
        }
    }


}