<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/2/18
 * Time: 16:09
 */

namespace common\models;


use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Message extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%message}}"; // TODO: Change the autogenerated stub
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ]; // TODO: Change the autogenerated stub
    }

    public function attributeLabels()
    {
        return [

        ]; // TODO: Change the autogenerated stub
    }
}