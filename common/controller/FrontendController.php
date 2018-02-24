<?php
/**
 * Created by PhpStorm.
 * Author: 火柴<290559038@qq.com>
 * Date: 2018/2/2
 * Time: 21:17
 */

namespace common\controller;


use Yii;
use yii\base\Module;

class FrontendController extends BaseController
{
    protected $user_info;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
//        var_dump(Yii::$app->user->identity);
        $this->user_info = Yii::$app->user->identity;
//        var_dump($this->user_info);
    }
}