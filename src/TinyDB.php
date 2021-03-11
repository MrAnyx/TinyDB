<?php

namespace MrAnyx;

use MrAnyx\Exception\FileException;
use MrAnyx\Exception\InitializationFailedException;
use MrAnyx\Exception\QueryException;

class TinyDB{

   public const TO_ARRAY = 1;
   public const TO_OBJECT = 2;

   private string $filePath;
   private string $fileData;
   private bool $pretify;
   private $file;

   /**
    * TinyDB constructor.
    * @param string $filePath
    * @param bool $pretify
    * @throws FileException
    * @throws InitializationFailedException
    */
   public function __construct(string $filePath, bool $pretify = true) {
      $this->pretify = $pretify;

      if(!isset($filePath) || empty($filePath)) {
         throw new InitializationFailedException();
      }

      if(!is_readable($filePath) || !is_writable($filePath)) {
         throw new FileException("File '{$filePath}' does not have the right access (read and write)");
      }

      $this->file = fopen($filePath, "w+") or die("Unable to create the data file {$filePath}");

      if(!file_exists($filePath)) {
         $this->init($this->file);
      } else {
         $this->filePath = $filePath;
         $this->fileData = file_get_contents($this->filePath);
      }


   }

   public function close() {
      fclose($this->file);
   }

   private function baseVerification() {

   }

   /**
    * @param $file
    */
   private function init($file) {
      fwrite($file, json_encode([
         "data" => [],
         "options" => [
            "content-hash" => hash("sha256", ""),
            "version" => time(),
            "creation" => time(),
         ]
      ], $this->pretify ? JSON_PRETTY_PRINT : null));
   }

   /**
    * @param int $format
    * @return mixed|null
    */
   public function getAll(int $format = self::TO_ARRAY) {
      if(empty($this->fileData)) {
         return null;
      } else {
         return json_decode($this->fileData, $format === self::TO_ARRAY);
      }
   }

   /**
    * @param string $key
    * @param int $format
    * @return mixed|object|null
    * @throws QueryException
    */
   public function get(string $key, int $format = self::TO_ARRAY) {
      if(empty($this->fileData)) {
         return null;
      } else {
         $result = json_decode($this->fileData, $format === self::TO_ARRAY);
         if(array_key_exists($key, $result)) {
            return $format === self::TO_ARRAY ? $result : (object)$result;
         } else {
            throw new QueryException("Index '{$key}' does not exist");
         }
      }
   }


}