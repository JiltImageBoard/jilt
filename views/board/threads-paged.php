<?php

use app\assets\PostsAssets;

/**
 * @var app\models\Thread[] $threads
 */

PostsAssets::register($this);
?>

<div>
    <?php foreach ($threads as $thread): ?>
        <div class="post">
            <div class="files">
                <?php foreach ($thread->postData->fileInfos as $fileInfo): ?>
                    <img src="<?= $fileInfo->thumbUrl ?>">
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>