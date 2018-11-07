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
        echo "这是用户第一次登录的时候, 登录之后会跳到这个页面";
        var_dump(Yii::$app->user->identity->username);
        exit;
    }

    //个人中心主页
    public function actionIndex()
    {

//        $this->view->title = "asdfasd";
        var_dump("这是用户已经登录过, 然后跳转到的页面");
//        var_dump($this->user_info);
        $data['user'] = $this->user_info;
        return $this->render('index', $data);
    }

    //我的订单
    public function actionOrder()
    {
        $uid                = $this->user_info->getId();
        $where['uid'] = $uid;
        $type = Yii::$app->request->get("type");
        if ($type){
            $where['type'] = $type;
        }
        $order              = Order::find()->where($where)->all();
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
        $data['cart_list'] = $cart;
        return $this->render('favorite', $data);
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