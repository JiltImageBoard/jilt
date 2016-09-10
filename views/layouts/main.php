<?php

use yii\helpers\Html;
use app\assets\AppAssets;

/* @var yii\web\View $this */
/* @var string $content */

AppAssets::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8"/>
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
    <?php $this->beginBody() ?>

    <?= $content ?>

    <?php $this->endBody() ?>
    </body>

    </html>
<?php $this->endPage() ?>