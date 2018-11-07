<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/3/20
 * Time: 10:38
 */

use frontend\assets\AppAsset;
use yii\helpers\Url;
?>

还剩:<span id="hour">00</span>:<span id="minute">00</span>:<span id="second">00</span>
<br/><br/><br/>
还剩:<span id="demo"></span>
<br/><br/><br/>
商品名称: <?= $goods->title; ?><br/><br/><br/>
商品详情: <?= $goods->body; ?><br/><br/><br/>

<form method="post" action="<?= Url::to(['generate-order'], false) ?>">
    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken; ?>"/>
    <input type="hidden" name="goods_id" value="<?= $goods->id; ?>"/>
    单独购买:<input type="text" readonly name="price" value="<?= $goods->price; ?>"/><br/><br/><br/>
    发起拼单:<input type="text" readonly name="collage_price" value="<?= $goods->collage_price; ?>"/><br/><br/><br/>
    <button type="submit">提交 <?= Url::to(['generate-order'], false) ?></button>
</form>


<script type="text/javascript">

    <?php $this->beginBlock('timer', false); ?>
    $(function () {
        function ShowCountDown(year, month, day) {
            let now = new Date();
            let endDate = new Date(year, month - 1, day);
            let leftTime = endDate.getTime() - now.getTime();
            let dd = parseInt(leftTime / 1000 / 60 / 60 / 24);//计算剩余的天数
            let hh = parseInt(leftTime / 1000 / 60 / 60 % 24);//计算剩余的小时数
            let mm = parseInt(leftTime / 1000 / 60 % 60);//计算剩余的分钟数
            let ss = parseInt(leftTime / 1000 % 60);//计算剩余的秒数
            dd = checkTime(dd);
            hh = checkTime(hh);
            mm = checkTime(mm);
            ss = checkTime(ss);//小于10的话加0
            let cc = $("#demo");
            // let innerText = "距离" + year + "年" + month + "月" + day + "日还有：" + dd + "天" + hh + "小时" + mm + "分" + ss + "秒";
            let innerText = dd + "天" + hh + ":" + mm + ":" + ss;
            cc.text(innerText);
            // console.log(innerText);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }

        setInterval(function () {
            ShowCountDown(2018, 4, 1, 'countdown');
        }, 1000);

    });
    <?php $this->endBlock(); ?>
</script>

<?php $this->registerJs($this->blocks['timer'], yii\web\View::POS_END); ?>

