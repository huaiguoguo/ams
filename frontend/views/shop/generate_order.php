<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/3/21
 * Time: 12:46
 */



//①、获取用户openid
use common\component\WxPay\JsApiPay;
use common\component\WxPay\Lib\WxPayApi;
use common\component\WxPay\Lib\WxPayConfig;

use common\component\WxPay\Lib\WxPayData\WxPayUnifiedOrder;
use yii\helpers\Url;

echo "这是表单提交页面";

exit;
$tools  = new JsApiPay();
$openId = $tools->GetOpenid();

$rate = 100;
$fee = 0.0001;

$total_fee = $rate * $fee;

//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("test");
$input->SetAttach("test");
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($total_fee);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url(Url::to(['/notify/index'], true));
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
dump($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

?>


这里是地址：河南省郑州市郑东新区 心怡路与正光路交叉口 金鹏时代4号楼1单元6层西

付款方式:微信支付 50元

<form method="post">

</form>
<br/>
<font color="#9ACD32"><b>该笔订单支付金额为<span style="color:#f00;font-size:50px"><?=$total_fee;?>块</span>钱</b></font><br/><br/>
<div align="center">
    <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
</div>

<script type="text/javascript">
    <?php $this->beginBlock('wxpay', false); ?>
    //调用微信JS api 支付
    function jsApiCall() {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest',
            <?php echo $jsApiParameters; ?>,
            function (res) {
                WeixinJSBridge.log(res.err_msg);
                //alert(res.err_code + res.err_desc + res.err_msg);
                window.location.href = "<?=Url::to(['shop/success_order'])?>";
            }
        );
    }

    function callpay() {
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
            } else if (document.attachEvent) {
                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
            }
        } else {
            jsApiCall();
        }
    }
    <?php $this->endBlock(); ?>
</script>

<?php $this->registerJs($this->blocks['wxpay'], yii\web\View::POS_END); ?>


