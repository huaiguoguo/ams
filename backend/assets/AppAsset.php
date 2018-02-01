<?php

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl  = '@web';
    public $css      = [
//        'css/site.css',
        "inspinia/css/bootstrap.min.css",
        "inspinia/font-awesome/css/font-awesome.css",
        "inspinia/css/plugins/codemirror/codemirror.css",
        "inspinia/css/plugins/codemirror/ambiance.css",
        "inspinia/css/plugins/toastr/toastr.min.css",
        "inspinia/js/plugins/gritter/jquery.gritter.css",
        "inspinia/css/animate.css",
        "inspinia/css/style.css",
    ];

    public $jsOptions = [
        'position' => View::POS_END,
    ];

    public $js = [
        "inspinia/js/jquery-3.1.1.min.js",
        "inspinia/js/bootstrap.min.js",
        'inspinia/js/inspinia.js',
        'inspinia/js/plugins/pace/pace.min.js',
        "inspinia/js/plugins/metisMenu/jquery.metisMenu.js",
        "inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js"
    ];

    public $depends = [
        //'yii\web\YiiAsset',
        //'yii\bootstrap\BootstrapAsset',
    ];


    public static function getAppAssetArr()
    {
        return [AppAsset::className(), 'depends' => 'backend\assets\AppAsset'];
    }

    public static function addJsFile(View $view, $file)
    {
        $view->registerJsFile($file, self::getAppAssetArr());
    }

    public static function addCssFile(View $view, $file)
    {
        $view->registerCssFile($file, self::getAppAssetArr());
    }

}
