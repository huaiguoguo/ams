<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/2/18
 * Time: 18:25
 */

namespace frontend\controllers;

use common\models\Cart;
use yii;
use common\controller\FrontendController;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends FrontendController
{
    //我的购物车
    public function actionIndex()
    {
        $data      = [];
        $uid       = $this->user_info->getId();
        $cart_list = Cart::find()->where(['uid' => $uid])->all();
        return $this->render('index', $data);
    }

    //生成订单
    public function actionGenerateOrder()
    {
        $response         = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $data           = [];
            $response->data = $data;

            $response->setStatusCode(200);
        } else {
            $response->data = ['code' => 400, 'msg' => '非法操作'];
            $response->setStatusCode(400);
        }
        $response->send();
    }



    /**
     * @author: 火柴<290559038@qq.com>
     * @descri: 添加商品到购物车
     * @throws NotFoundHttpException
     */
    public function actionAdd()
    {
        $response = Yii::$app->response;
        $response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $gid   = Yii::$app->request->post('gid');
            $num   = Yii::$app->request->post('num');
            $price = Yii::$app->request->post('price');
            if (!$gid) {
                throw new NotFoundHttpException("无此商品", 404);
            }

            $cart        = new Cart();
            $cart->gid   = $gid;
            $cart->uid   = $this->user_info->getId();
            $cart->num   = $num;
            $cart->price = $price;
            $cart->total = $num * $price;
            if ($cart->save()) {
                $response->data = [];
            }else{
                $response->data = [];
            }
            $response->send();
        }else{
            $response->send();
        }
    }



}