<?php
/**
 * Created by PhpStorm.
 * User: gf
 * Date: 2018/1/31
 * Time: 10:39
 */

namespace backend\controllers;


use yii;
use yii\helpers\VarDumper;
use common\controller\BackendController;

class WechatController extends BackendController
{

//    public function beforeAction($action)
//    {
//        $currentaction  = $action->id;
//        $novalidactions = ['dologin'];
//        if (in_array($currentaction, $novalidactions)) {
//            $action->controller->enableCsrfValidation = false;
//        }
//        return parent::beforeAction($action);
//    }

    public $enableCsrfValidation = false;


    public function actionSucai()
    {
        $this->getMaterialList();
    }

    //公众号设置

    public function actionSetwechat()
    {
        return $this->render('setwechat');
    }


    public function actionIndex()
    {
        $echoStr = Yii::$app->request->get('echostr');
        if ($this->checkSignature() && Yii::$app->request->get('echostr')) {
            return $echoStr;
        } else {
            return $this->responseMsg();
        }
    }


    //返回消息
    public function responseMsg()
    {
        $postAtr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        $postObj = simplexml_load_string($postAtr);
        return $this->msgTypeCase($postObj);
    }



    //创建菜单
    public function actionCreateItem()
    {
        $access_toke = $this->getWxAccessToken();
        $url         = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_toke";
        $data        = [
            'button' => [
                ['type' => 'view', 'name' => '火柴博客', 'url' => 'http://www.phpdx.me'],
                ['type' => 'click', 'name' => '关于', 'key' => 'aboutme']
            ]
        ];
        $data        = json_encode($data, JSON_UNESCAPED_UNICODE);
        $result      = $this->https_request($url, $data);

        var_dump($result);

    }


    //创建菜单
    public function actionCreateMenu()
    {

    }





}