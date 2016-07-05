<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DebugAssets;

/* @var yii\web\View $this */
/* @var string $content */

DebugAssets::register($this);

$form = ActiveForm::begin([
    'id' => 'thread-creation-form'
]);
?>

<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?= $form->field($postMessage, 'text')->textarea()->label('Post Text') ?>
            <?= $form->field($postData, 'name') ?>
            <?= $form->field($postData, 'subject') ?>
            <?= $form->field($thread, 'isChat')->checkbox() ?>

            <div id="files" style="margin: 25px 0px 25px 0px;"></div>

            <?= Html::submitButton('Create thread', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>

