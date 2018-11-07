<?php
/**
 * 
 * 微信支付API异常类
 * @author widyhu
 *
 */

namespace common\component\WxPay\Lib;


use yii\base\Exception;

class WxPayException extends Exception {
	public function errorMessage()
	{
		return $this->getMessage();
	}
}
