<?php

namespace rplvrtha\camera;

use rplvrtha\camera\assets\Yii2CamAsset;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

class Yii2Cam extends Widget
{
    public $uploadUrl;
    public $onSuccess = null;
    public $onError = null;
    public $buttonText = 'Buka Kamera';
    public $retakeText = 'Ambil Ulang Gambar';
    public $previewWidth = '100%';
    public $previewClass = '';

    public function run()
    {
        Yii2CamAsset::register($this->getView());

        $options = Json::encode([
            'uploadUrl' => $this->uploadUrl,
            'onSuccess' => $this->onSuccess,
            'onError' => $this->onError,
            'retakeText' => $this->retakeText,
        ]);

        $this->getView()->registerJs("
            window.cameraWidgetOptions = {$options};
        ", View::POS_HEAD);

        $html = Html::tag(
            'div',
            Html::img('', [
                'id' => 'previewImage',
                'class' => "img-fluid mb-3 $this->previewClass",
                'style' => "width: $this->previewWidth; display: none;",
                'alt' => 'Pratinjau Gambar'
            ]) .
                Html::button($this->buttonText, [
                    'id' => 'openNativeCamera',
                    'class' => 'btn btn-primary btn-lg w-100'
                ]) .
                Html::fileInput('imageFile', null, [
                    'accept' => 'image/*',
                    'capture' => 'environment',
                    'id' => 'fileInput',
                    'style' => 'display: none;'
                ]),
            ['class' => 'camera-container p-4']
        );

        return $html;
    }
}
