<?php

namespace Zero\Pay\Helper;

class DataCheck
{
   public static function whetherEmpty($setParameter, $message)
   {
      if (empty($setParameter)) {
         throw new \Exception($message);
      }
   }
}
