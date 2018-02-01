<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/2/1
 * Time: 19:44
 */

namespace common\controller;

use yii;
use yii\base\Module;
use yii\helpers\VarDumper;
use yii\web\Controller;

class BackendController extends Controller
{


    private $APPID = "wx14b4165730ea6547";
    private $APPSECRET = "4b8cda25ebc1898e4ec5b3014c64b5ca";
    private $db;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->db = Yii::$app->db;
    }

    /**
     * https请求
     * @param unknown $url
     * @param string $data
     * @return mixed
     */
    function http_request($url, $data = null, $https = false)
    {
        $curl = curl_init();
//        $header[] = "Host:api.weixin.qq.com";
        curl_setopt($curl, CURLOPT_URL, $url);
//        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
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
            echo "错误原因: " . $error;
        }
        curl_close($curl);

        return $output;
    }

    function https_request($url, $data = null)
    {
        return $this->http_request($url, $data, true);
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

        $data        = json_encode($map, JSON_UNESCAPED_UNICODE);
        $result      = $this->https_request($url, $data);
        $result      = json_decode($result);
        echo "<pre>";
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

        $txt = "<?php return '$request_result_json';";
        $file_handle = fopen($file_name, "w+") or die("Unable to open file!");
        fwrite($file_handle, $txt);
        fclose($file_handle);

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
            'access_token' => 'https://api.weixin.qq.com/cgi-bin/token',
            'material'     => 'https://api.weixin.qq.com/cgi-bin/material/batchget_material',
        ];

        if ($key) {
            return $api_list[$key];
        }

        return $api_list;
    }

}