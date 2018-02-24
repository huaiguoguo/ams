<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/2/14
 * Time: 18:44
 */

namespace frontend\controllers;


use common\controller\FrontendController;
use common\models\Address;
use common\models\Cart;
use common\models\Favorite;
use common\models\Message;
use common\models\Order;
use common\models\UserCoupon;
use Yii;

class UserController extends FrontendController
{

    public function actionHaha()
    {
//        var_dump(Yii::$app->user->identity->username);
        exit;
    }

    //个人中心主页
    public function actionIndex()
    {
        echo "adsfasd";
        var_dump($this->user_info);
        exit;

        return $this->render('index');
    }

    //我的订单
    public function actionTest()
    {
        $uid                = $this->user_info->getId();
        $order              = Order::find()->where(['uid' => $uid])->all();
        $data['order_list'] = $order;

        return $this->render('order', $data);
    }

    //我的收藏
    public function actionFavorite()
    {
        $uid              = $this->user_info->getId();
        $favorite         = Favorite::find()->where(['uid' => $uid])->all();
        $data['favorite'] = $favorite;

        return $this->render('favorite', $data);
    }

    //购物车
    public function actionCart()
    {
        $uid  = $this->user_info->getId();
        $cart = Cart::find()->where(['uid' => $uid])->all();

    }

    //收货地址管理
    public function actionAddress()
    {
        $uid             = $this->user_info->getId();
        $address         = Address::find()->where(['uid' => $uid])->all();
        $data['address'] = $address;

        return $this->render('address', $data);
    }

    //消息
    public function actionMessage()
    {
        $uid             = $this->user_info->getId();
        $message         = Message::find()->where(['uid' => $uid])->all();
        $data['message'] = $message;

        return $this->render('message', $data);
    }

    //优惠券 礼品卡
    public function actionCoupon()
    {
        $uid            = $this->user_info->getId();
        $coupon         = UserCoupon::find()->where(['uid' => $uid])->all();
        $data['coupon'] = $coupon;

        return $this->render('coupon', $data);
    }

    //我的积分
    public function actionIntegral()
    {

    }


    //我的订单
    public function actionMyOrder()
    {
        $uid    = $this->user_info->getId();
        $orders = Order::find()->where(['uid' => $uid])->all();
    }

    //分销中心
    public function actionDistributor()
    {
    }


    //充值中心
    public function actionRecharge()
    {
    }


}