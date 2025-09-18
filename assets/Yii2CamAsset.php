<?php
namespace rplvrtha\camera\assets;

use yii\web\AssetBundle;

class Yii2CamAsset extends AssetBundle
{
    public $sourcePath = '@vendor/rplvrtha/yii2-camera/assets';
    public $js = [
        'js/camera.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}