<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/3/19
 * Time: 20:11
 */

namespace frontend\controllers;


use common\controller\FrontendController;

class RechargeController extends FrontendController
{
    public function beforeAction($action)
    {
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        return parent::actions(); // TODO: Change the autogenerated stub
    }



    public function actionIndex()
    {
        $data = [];
        return $this->render('index', $data);
    }


}