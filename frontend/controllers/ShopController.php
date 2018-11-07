<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/3/20
 * Time: 10:18
 */

namespace frontend\controllers;

use common\controller\FrontendController;
use common\helpers\VarDumper;
use common\models\Goods;
use Exception;
use Yii;

class ShopController extends FrontendController
{

    public function actionIndex()
    {
        $data[] = '';

        return $this->render('index', $data);
    }


    public function actionDetail()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => '哈哈']);
        $data[] = '';

        $id = 1;

        $detail        = Goods::findOne($id);
        $data['goods'] = $detail;
//        dump($detail);
//        exit;

        return $this->render('detail', $data);
    }

    /**
     * @author: 火柴<290559038@qq.com>
     * @descri: ......
     * @throws Exception
     */
    public function actionGenerateOrder()
    {
        $this->view->title = "这是商品支付页面";

        return $this->render('generate_order');
    }

    public function actionSuccessOrder()
    {
        $data = [];

        return $this->render('success_order', $data);
    }


    public function actionTest()
    {
//        $store  = 1000;
//        $redis = Yii::$app->redis;
//        $res = $redis->llen('goods_store');
//        $count = $store - $res;
//        for ($i = 0; $i < $count; $i++) {
//            $redis->lpush('goods_store', 1);
//        }
//        $count = $redis->llen('goods_store');
    }
}