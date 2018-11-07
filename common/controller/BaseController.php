<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/2/2
 * Time: 21:16
 */

namespace common\controller;

use Yii;
use yii\base\Module;
use yii\web\Controller;
use common\helpers\VarDumper;

class BaseController extends Controller
{
    protected $TOKEN     = "haowai";
    protected $APPID     = "wx14b4165730ea6547";
    protected $APPSECRET = "4b8cda25ebc1898e4ec5b3014c64b5ca";
    protected $db;

    // public function __construct($id, Module $module, array $config = [])
    // {
    //     parent::__construct($id, $module, $config);
    //     $this->db = Yii::$app->db;
    // }

    //验证签名
    public function checkSignature()
    {
        $nonce     = Yii::$app->request->get('nonce');
        $signature = Yii::$app->request->get('signature');
        $timestamp = Yii::$app->request->get('timestamp');

        $temparray = array($this->TOKEN, $timestamp, $nonce);
        sort($temparray, SORT_STRING);
        $tempstr = implode($temparray);
        $tempstr = sha1($tempstr);
        if ($tempstr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @author: 火柴<290559038@qq.com>
     * @descri: 获取素材列表
     */
    public function getMaterialList()
    {
        $access_toke = $this->getWxAccessToken();
        $url         = $this->getApiUrlByKey("material");
        $url         .= '?access_token=' . $access_toke;
        $map         = [
            'type'   => 'news',
            'offset' => '0',
            'count'  => '20'
        ];

        $data   = json_encode($map, JSON_UNESCAPED_UNICODE);
        $result = $this->https_request($url, $data);
        $result = json_decode($result);
        VarDumper::dump($result);
        exit;

    }


    /**
     * @author: 火柴<290559038@qq.com>
     * @descri: 获得access_token 并保存到数据库
     */
    public function getWxAccessToken()
    {
        $file_name         = Yii::getAlias("@common") . "/data/access_token.php";
        $access_token_json = require $file_name;
        $access_token      = json_decode($access_token_json, true);
        if ($access_token['time'] + $access_token['expires_in'] > time()) {
            echo "未过期";
            return $access_token['access_token'];
        }

        $data['appid']              = $this->APPID;
        $data['secret']             = $this->APPSECRET;
        $data['grant_type']         = 'client_credential';
        $url                        = $this->getApiUrlByKey("access_token");
        $request_result             = $this->https_request($url, $data);
        $request_result_arr         = json_decode($request_result, true);
        $request_result_arr['time'] = time();
        $request_result_json        = json_encode($request_result_arr);

        $result = "<?php return '$request_result_json';";
        $file_handle = fopen($file_name, "w+") or die("Unable to open file!");
        fwrite($file_handle, $result);
        fclose($file_handle);

        $access_token = $request_result_arr['token'];
        return $access_token;

    }


    /**
     * @author: 火柴<290559038@qq.com>
     * @descri: 获得access_token
     * @param $key
     * @return array|mixed
     */
    public function getApiUrlByKey($key)
    {
        $api_list = [
            'access_token'  => 'https://api.weixin.qq.com/cgi-bin/token',
            'material'      => 'https://api.weixin.qq.com/cgi-bin/material/batchget_material',
            'getcallbackip' => 'https://api.weixin.qq.com/cgi-bin/getcallbackip',
        ];
        if ($key) {
            return $api_list[$key];
        }
        return null;
    }

    //获取微信的ip  可以作为验证请求来源是否是微信的服务器
    public function actionGetWxServiceIp()
    {
        $access_token = $this->getWxAccessToken();
        $url          = $this->getApiUrlByKey("getcallbackip");
        $url          .= "?access_token=" . $access_token;
        $result       = $this->https_request($url);
        VarDumper::dump($result);
    }



    public function msgTypeCase($postObj)
    {
        $response = '';
        Yii::error($postObj, 'wechat');
        $MsgType  = strtolower($postObj->MsgType);
        switch ($MsgType) {
            case "event":
                $response = $this->eventMsg($postObj);
                break;
            case "text":
                $response = $this->textMsg($postObj);
                break;
            case "image":
                $response = $this->imageMsg($postObj);
                break;
            case "voice":
                $response = $this->videoMsg($postObj);
                break;
            case "video":
                $response = $this->videoMsg($postObj);
                break;
            case "shortvideo":
                $response = $this->shortVideoMsg($postObj);
                break;
            case "location":
                $response = $this->locationMsg($postObj);
                break;
            case "link":
                $response = $this->linkMsg($postObj);
                break;
        }
        return $response;
    }

    //文本消息
    public function textMsg($postObj)
    {
        $toUser          = $postObj->ToUserName;
        $fromUser        = $postObj->FromUserName;
        $time            = time();
        $ResponseMsgType = 'text';
        if ($postObj->Content == 'aboutmet') {
            $Content = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        } elseif ($postObj->Content == '图文消息') {
            return sprintf($this->TemplatePicText(), $fromUser, $toUser, time(), "news");
        } else {
            $Content = "你好, 谢谢关注, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        }
    }

    //图片消息
    public function imageMsg($postObj)
    {
        $toUser          = $postObj->ToUserName;
        $fromUser        = $postObj->FromUserName;
        $time            = time();
        $ResponseMsgType = 'news';


        return sprintf($this->templateImageText(), $fromUser, $toUser, $time, $ResponseMsgType);

        if ($postObj->Content == 'aboutmet') {
            $Content = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
            return sprintf($this->templateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        } elseif ($postObj->Content == '图文消息') {
            return sprintf($this->templateImageText(), $fromUser, $toUser, time(), "news");
        } else {
            $Content = "你好, 谢谢关注, 欢迎给我留言";
            return sprintf($this->templateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        }
    }

    //语音消息
    public function voiceMsg($postObj)
    {
        $toUser          = $postObj->ToUserName;
        $fromUser        = $postObj->FromUserName;
        $time            = time();
        $ResponseMsgType = 'text';
        if ($postObj->Content == 'aboutmet') {
            $Content = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        } elseif ($postObj->Content == '图文消息') {
            return sprintf($this->TemplatePicText(), $fromUser, $toUser, time(), "news");
        } else {
            $Content = "你好, 谢谢关注, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        }
    }

    //视频消息
    public function videoMsg($postObj)
    {
        $toUser          = $postObj->ToUserName;
        $fromUser        = $postObj->FromUserName;
        $time            = time();
        $ResponseMsgType = 'text';
        if ($postObj->Content == 'aboutmet') {
            $Content = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        } elseif ($postObj->Content == '图文消息') {
            return sprintf($this->TemplatePicText(), $fromUser, $toUser, time(), "news");
        } else {
            $Content = "你好, 谢谢关注, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        }
    }

    //小视频消息
    public function shortVideoMsg($postObj)
    {
        $toUser          = $postObj->ToUserName;
        $fromUser        = $postObj->FromUserName;
        $time            = time();
        $ResponseMsgType = 'text';
        if ($postObj->Content == 'aboutmet') {
            $Content = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        } elseif ($postObj->Content == '图文消息') {
            return sprintf($this->TemplatePicText(), $fromUser, $toUser, time(), "news");
        } else {
            $Content = "你好, 谢谢关注, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        }
    }

    //地理位置消息
    public function locationMsg($postObj)
    {
        $toUser          = $postObj->ToUserName;
        $fromUser        = $postObj->FromUserName;
        $time            = time();
        $ResponseMsgType = 'text';
        $Content = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
        return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        if ($postObj->Content == 'aboutmet') {
            $Content = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        } elseif ($postObj->Content == '图文消息') {
            return sprintf($this->TemplatePicText(), $fromUser, $toUser, time(), "news");
        } else {
            $Content = "你好, 谢谢关注, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        }
    }

    //链接消息
    public function linkMsg($postObj)
    {
        $toUser          = $postObj->ToUserName;
        $fromUser        = $postObj->FromUserName;
        $time            = time();
        $ResponseMsgType = 'text';
        if ($postObj->Content == 'aboutmet') {
            $Content = "你好, 我是火柴, 是一名phper, 如果有什么技术需求, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        } elseif ($postObj->Content == '图文消息') {
            return sprintf($this->TemplatePicText(), $fromUser, $toUser, time(), "news");
        } else {
            $Content = "你好, 谢谢关注, 欢迎给我留言";
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        }
    }

    //事件消息
    public function eventMsg($postObj)
    {
        $toUser          = $postObj->ToUserName;
        $fromUser        = $postObj->FromUserName;
        $time            = time();
        $ResponseMsgType = 'text';
        if (strtolower($postObj->Event) == 'subscribe') {
            $Content = "你好,欢迎关注火柴头\n公众账号:" . $toUser . "\n微信用户:" . $fromUser;
            return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
        }

        if (strtolower($postObj->Event) == 'click') {
            if ($postObj->EventKey == 'aboutme') {
                $Content = "你好,这是菜单<关于我>的点击事件";
                return sprintf($this->TemplateText(), $fromUser, $toUser, $time, $ResponseMsgType, $Content);
            }
        }
    }



    //文本消息模板
    public function templateText()
    {
        $template = "<xml><ToUserName><![CDATA[%s]]></ToUserName>
                                <FromUserName><![CDATA[%s]]></FromUserName>
                                <CreateTime>%s</CreateTime>
                                <MsgType><![CDATA[%s]]></MsgType>
                                <Content><![CDATA[%s]]></Content></xml>";
        return $template;
    }

    //图文消息模板
    public function templateImageText()
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

    //curl http请求
    function http_request($url, $data = null, $https = false)
    {
        $curl = curl_init();
        //$header[] = "Host:api.weixin.qq.com";
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回

        if ($https) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);// 对认证证书来源的检查
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);// 从证书中检查SSL加密算法是否存在
        }
        if (!empty ($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        if (!$output) {
            $error = curl_error($curl);
            echo "错误原因: " . $error . '<br/>';
        }
        curl_close($curl);
        return $output;
    }

    //curl https请求
    function https_request($url, $data = null)
    {
        return $this->http_request($url, $data, true);
    }
}