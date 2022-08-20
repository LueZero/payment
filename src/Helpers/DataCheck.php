<?php

namespace Zero\Payment\Helpers;

class DataCheck
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
    * 詳細參數檢查
    */
   public static function exhaustiveCheckSends($necessaryParameters, $sends, $key)
   {
      foreach ($necessaryParameters[$key] as $checkoutParameter) {
         if (empty($sends[$checkoutParameter])) {
            throw new \Exception("{$checkoutParameter} parameter missing ");
         }
      }
   }

   /**
    * 檢查總金額
    */
   public static function checkTotalAmount($amount)
   {
      if ($amount < 1) {
         throw new \Exception('The total amount cannot be less than 0');
      }
   }

   /**
    * 檢查訂單編號
    */
   public static function checkOrderNumber($orderNumber, $key)
   {
      if (empty($orderNumber)) {
         throw new \Exception("{$key} number is empty");
      }
   }
}
