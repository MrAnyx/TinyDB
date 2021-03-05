<?php

namespace MrAnyx\Exception;

use Exception;
use Throwable;

class QueryException extends Exception
{
   public function __construct($message, $code = 0, Throwable $previous = null) {
      parent::__construct($message, $code, $previous);
   }

}