<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/3/19
 * Time: 11:08
 */

use common\helpers\VarDumper;
use yii\helpers\Html;

?>

<style>

    .list{
        /*width: 100%;*/
        /*height: 100%;*/
        background: transparent;
    }

    .list ul{
        list-style: none;
    }

    .list ul li{
        line-height: 60px;
    }

</style>

<div class="list">
    <ul>
        <li><?=Html::a("商城首页", ['shop/index']);?></li>
        <li><?=Html::a("商品详细页", ['shop/detail', 'gid'=>1]);?></li>
        <li><?=Html::a("充值中心", ['recharge/index']);?></li>
        <li><?=Html::a("分销中心", ['distributor/index']);?></li>
        <li><?=Html::a("幸运转盘", ['recharge/index']);?></li>
        <li><?=Html::a("我的订单", ['order/index']);?></li>
        <li><?=Html::a("地址管理", ['address/index']);?></li>
        <li><?=Html::a("设置", ['seting/index']);?></li>
        <li><?=Html::a("意见反馈", ['recharge/index']);?></li>
        <li><?=Html::a("联系客户", ['recharge/index']);?></li>
    </ul>
</div>