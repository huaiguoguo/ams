<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/3/19
 * Time: 11:58
 */

namespace common\helpers;


class VarDumper extends \yii\helpers\VarDumper
{
        public static function dump($var, $depth = 10, $highlight = true)
        {
            parent::dump($var, $depth, $highlight); // TODO: Change the autogenerated stub
        }
}