<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/3/21
 * Time: 16:27
 */

namespace frontend\controllers;



use common\component\WxPay\PayNotifyCallBack;
use common\controller\FrontendController;
use Yii;


class NotifyController extends FrontendController
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
//        $this->enableCsrfValidation = false;
        Yii::info("begin notify");
        $notify = new PayNotifyCallBack();
        $notify->Handle(false);
    }
}