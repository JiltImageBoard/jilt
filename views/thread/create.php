<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\DebugAssets;

/**
 * @var yii\web\View $this
 * @var string $content
 * @var \app\models\PostData $postData
 * @var \app\models\Thread $thread
 */

DebugAssets::register($this);

$this->title = 'test';
?>

<div class="container" style="margin-top: 50px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <?php $form = ActiveForm::begin(['id' => 'threadCreateForm']); ?>
            <?= $form->field($postData, 'messageText')->textarea()->label('Post Text') ?>
            <?= $form->field($postData, 'name') ?>
            <?= $form->field($postData, 'subject') ?>
            <?= $form->field($thread, 'isChat')->checkbox() ?>

            <!-- TODO: make widget instead -->
            <div id="files" style="margin: 25px 0px 25px 0px;"></div>

            <?= Html::submitButton('Create thread', ['class' => 'btn btn-primary']) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>
