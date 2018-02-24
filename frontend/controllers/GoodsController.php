<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/2/18
 * Time: 17:50
 */

namespace frontend\controllers;


use common\controller\FrontendController;
use common\models\Cart;
use common\models\Goods;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class GoodsController extends FrontendController
{
    //商品列表
    public function actionIndex()
    {
        $list         = Goods::find()->all();
        $data['list'] = $list;

        return $this->render('index', $data);
    }


    /**
     * @author: 火柴<290559038@qq.com>
     * @descri: 商品详情
     * @throws NotFoundHttpException
     */
    public function actionDetail()
    {
        $gid = Yii::$app->request->get('gid');
        if (!$gid) {
            throw new NotFoundHttpException("无此商品", 404);
        }
        $detail         = Goods::findOne($gid);
        $data['detail'] = $detail;

        return $this->render('detail', $data);
    }





}