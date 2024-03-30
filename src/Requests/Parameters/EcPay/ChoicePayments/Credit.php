<?php

namespace Zero\Requests\Parameters\ECPay\ChoicePayments;

use Zero\Requests\Parameters\ECPay\ChoicePayments\Base;

class Credit extends Base
{
  /**
   * @var string
   */
  public $Redeem;

  /**
   * @var int
   */
  public $UnionPay;

  /**
   * @var int
   */
  public $BindingCard;

  /**
   * @var string
   */
  public $MerchantMemberID;

  /////////////////////////

  /**
   * @var int
   */
  public $PeriodAmount;

  /**
   * @var string
   */
  public $PeriodType;

  /**
   * @var int
   */
  public $Frequency;

  /**
   * @var int
   */
  public $ExecTimes;

  /**
   * @var string 
   */
  public $PeriodReturnURL;

  /////////////////////////
  
  /**
   * @var string 
   */
  public $CreditInstallment;
}
