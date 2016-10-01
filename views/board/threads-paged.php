<?php

use app\models\Thread;

/**
 * @var Thread[] $threads
 */
?>

<div>
    <?php foreach ($threads as $thread): ?>
        <?php $postData = $thread->postData; ?>

        <?= $this->render('//post/_post-data', ['postData' => $postData]) ?>
    <?php endforeach; ?>
</div>