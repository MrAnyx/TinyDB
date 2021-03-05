<?php

namespace MrAnyx\Exception;

use Exception;
use Throwable;

class InitializationFailedException extends Exception
{
   public function __construct($code = 0, Throwable $previous = null) {
      parent::__construct("File has not been initialized", $code, $previous);
   }

}