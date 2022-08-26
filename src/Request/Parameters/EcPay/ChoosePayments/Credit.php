<?php

namespace Zero\Request\Parameters\EcPay\ChoosePayments;

use Zero\Request\Parameters\EcPay\ChoosePayments\Base;

class Credit extends Base
{
  /**
   * string redeem
   */
  public $Redeem;

  /**
   * int unionPay
   */
  public $UnionPay;

  /**
   * int bindingCard
   */
  public $BindingCard;

  /**
   * string merchantMemberID
   */
  public $MerchantMemberID;

  /////////////////////////

  /**
   * int periodAmount
   */
  public $PeriodAmount;

  /**
   * string periodType
   */
  public $PeriodType;

  /**
   * int frequency
   */
  public $Frequency;

  /**
   * int execTimes
   */
  public $ExecTimes;

  /**
   * string periodReturnURL 
   */
  public $PeriodReturnURL;

  /////////////////////////
  
  /**
   * string creditInstallment 
   */
  public $CreditInstallment;
}
