<?php

namespace MrAnyx;

use MrAnyx\Exception\FileException;
use MrAnyx\Exception\InitializationFailedException;
use MrAnyx\Exception\QueryException;

class TinyDB{

   public const TO_ARRAY = 1;
   public const TO_OBJECT = 2;

   private string $filePath;
   private string $fileContent;

   public function __construct(string $filePath) {
      if(!isset($filePath) || empty($filePath)) {
         throw new InitializationFailedException();
      } elseif(!file_exists($filePath)) {
         throw new FileException("File '{$filePath}' does not exist");
      } elseif(!is_readable($filePath) || !is_writable($filePath)) {
         throw new FileException("File '{$filePath}' does not have the right access (read and write)");
      } else {
         $this->filePath = $filePath;
         $this->fileContent = file_get_contents($this->filePath);
      }
   }

   public function getAll(int $toArray = self::TO_ARRAY) {
      if(empty($this->fileContent)) {
         return null;
      } else {
         return json_decode($this->fileContent, $toArray === self::TO_ARRAY);
      }
   }

   public function get(string $key, int $toArray = self::TO_ARRAY) {
      if(empty($this->fileContent)) {
         return null;
      } else {
         $result = json_decode($this->fileContent, $toArray === self::TO_ARRAY);
         if(array_key_exists($key, $result)) {
            return $toArray === self::TO_ARRAY ? $result : (object)$result;
         } else {
            throw new QueryException("Index '{$key}' does not exist");
         }
      }
   }


}