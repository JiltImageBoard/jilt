<?php

use app\assets\PostsAssets;
use app\models\Thread;

/**
 * @var Thread[] $threads
 * @var string   $defaultName
 */

PostsAssets::register($this);
?>

<div>
    <?php foreach ($threads as $thread): ?>
        <?php $postData = $thread->postData; ?>

        <div class="post">
            <div class="header">
                <span class="subject"><?= $postData->subject ?></span>
                <span><?= $postData->name ? $postData->name : $defaultName ?></span>
                <span><?= $postData->createdAt ?></span>
            </div>

            <div class="files">
                <?php foreach ($postData->fileInfos as $fileInfo): ?>
                    <img src="<?= $fileInfo->thumbUrl ?>">
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>