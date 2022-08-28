<?php

namespace Zero\Helpers;

class DataChecker
{
   /**
    * 參數判斷
    */
   public static function whetherEmpty($parameters, $message)
   {
      if (empty($parameters)) {
         throw new \Exception($message);
      }
   }

   /**
    * 檢查總金額
    */
   public static function checkTotalAmount($amount)
   {
      if ($amount < 1) {
         throw new \Exception('Zero\Payment::[The total amount cannot be less than 0]');
      }
   }

   /**
    * 檢查訂單編號
    */
   public static function checkOrderNumber($orderNumber, $key)
   {
      if (empty($orderNumber)) {
         throw new \Exception("Zero\Payment::[{$key} number is empty]");
      }
   }
}
