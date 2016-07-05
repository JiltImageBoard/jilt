<?php
/**
 * Created by PhpStorm.
 * User: null
 * Date: 02.07.16
 * Time: 02:42
 */

namespace app\assets;

use yii\web\AssetBundle;

class DebugAssets extends AssetBundle
{
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
    public $js = [
        'js/logger.js'
    ];
}