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

    public function checkSignature()
    {
        $signature = Yii::$app->request->get('signature');
        $timestamp = Yii::$app->request->get('timestamp');
        $nonce     = Yii::$app->request->get('nonce');
        $token     = "huochai";
        $tmparray  = array($token, $timestamp, $nonce);
        sort($tmparray, SORT_STRING);
        $tmpstr = implode($tmparray);
        $tmpstr = sha1($tmpstr);
        if ($tmpstr == $signature) {
            return true;
        } else {
            return false;
        }
    }


    public function responseMsg()
    {
        $postAtr = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents("php://input");
        // 2.处理消息类型
        $postObj = simplexml_load_string($postAtr);
        if (strtolower($postObj->MsgType) == 'event') {
            //如果是关注事件 ：subscribe
            if ($postObj->Event == 'subscribe') {
                //回复用户消信息
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $MsgType  = 'text';
                $Content  = "你好,欢迎关注火柴头\n公众账号:" . $postObj->ToUserName . "\n微信用户:" . $postObj->FromUserName;
                $template = "
                                <xml>
                                <ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content>
                                </xml>
                            ";
                $info     = sprintf($template, $toUser, $fromUser, $time, $MsgType, $Content);

                return $info;
            }

            if (strtolower($postObj->Event) == 'click') {
                if ($postObj->EventKey == 'aboutme') {
                    $toUser   = $postObj->FromUserName;
                    $fromUser = $postObj->ToUserName;
                    $time     = time();
                    $MsgType  = 'text';
                    $Content  = "你好, 我是名phper";
                    $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content></xml>";
                    return sprintf($template, $toUser, $fromUser, $time, $MsgType, $Content);

                }
            }
        }

        if (strtolower($postObj->MsgType) == 'text') {

            if ($postObj->Content == 'aboutmet') {
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $MsgType  = 'text';
                $Content  = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
                $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content></xml>";
                return sprintf($template, $toUser, $fromUser, $time, $MsgType, $Content);

            } elseif ($postObj->Content == 'tuwen1') {
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                return sprintf($this->TemplatePicText(), $toUser, $fromUser, time(), "news");
            } else {
                $toUser   = $postObj->FromUserName;
                $fromUser = $postObj->ToUserName;
                $time     = time();
                $MsgType  = 'text';
                $Content  = "你好, 谢谢关注, 欢迎给我留言";
                $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content></xml>";
                return sprintf($template, $toUser, $fromUser, $time, $MsgType, $Content);
            }
        }

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


    //获取access_token
    public function actionGetAccessToken()
    {
//        $appid = "wxa25fb4f0180cfb59";
//        $appsecret = "d020cff1db67b9b7425be30d0c369aa2";
        $appid     = "wx14b4165730ea6547";
        $appsecret = "4b8cda25ebc1898e4ec5b3014c64b5ca";
        $url       = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        //2018-01-31 17:30
        $token = "6_z5DkdcQRjGnBOHeYiRlbViQ_er8BWEvB5fEuT4uqPcqWXlfkHjpRv8o0YzuT1TSTS6QF51PyGdF62oBxgE4-U8xclAxR4XQeLpGABphWdHZ77AjysFB01vl0JBJV7w_jnU1R05Y2V4EnJ6AfZYGfAGATSA";
        $ch    = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $access_token = curl_exec($ch);
        if (curl_errno($ch)) {
            var_dump(curl_error($ch));
        }
        curl_close($ch);
        $arr = json_decode($access_token, true);
        var_dump($arr);
    }

    public function actionGetWxServiceIp()
    {
        $access_token = "WmKwR23DgKVSassakpbHseedCYjAexfSmWsN-_Y53-rfir0LU2Xj8rZJcf_yBZ3-W2R0Nn-AdmANYn4xQTVdf7b6lZVOjVqJDUFo9xRgvW-bKJfLDybn-_bSZd-8Iw9yTKXdAFAPGT";
        $url          = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=" . $access_token;
        $ch           = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ip = curl_exec($ch);
        if (curl_errno($ch)) {
            var_dump(curl_error($ch));
        }
        curl_close($ch);
        $arr = json_decode($ip, true);
        dump($arr);
    }


    public function actionHttpcurl()
    {
        $ch  = curl_init();
        $url = "http://www.qq.com";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        print_r($output);
    }


    //图文消息模板
    public function TemplatePicText()
    {
        $arr = [
            [
                'title'       => '淘宝',
                'description' => '淘宝描述',
                'picUrl'      => 'https://img.alicdn.com/tps/i4/TB1iTkVLFXXXXXNaXXXAF6IGpXX-160-66.png_80x80.jpg',
                'url'         => 'http://www.taobao.com'
            ],
            [
                'title'       => '百度',
                'description' => '百度描述',
                'picUrl'      => 'https://www.baidu.com/img/bd_logo1.png',
                'url'         => 'http://www.baidu.com'
            ],
            [
                'title'       => '腾讯',
                'description' => '腾讯描述',
                'picUrl'      => 'http://mat1.gtimg.com/www/images/qq2012/qqlogo_2x.png',
                'url'         => 'http://www.qq.com'
            ]
        ];

        $template = "
                        <xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <ArticleCount>" . count($arr) . "</ArticleCount>
                        <Articles>";

        foreach ($arr as $key => $value) {
            $template .= "<item>
                        <Title><![CDATA[" . $value['title'] . "]]></Title>
                        <Description><![CDATA[" . $value['description'] . "]]></Description>
                        <PicUrl><![CDATA[" . $value['picUrl'] . "]]></PicUrl>
                        <Url><![CDATA[" . $value['url'] . "]]></Url>
                        </item>";
        }


        $template .= "</Articles>
                        </xml>";

        return $template;

    }


}