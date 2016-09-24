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

        <div>
            <div class="post">
                <div class="header">
                    <span class="subject"><?= $postData->subject ?></span>
                    <span><?= $postData->name ? $postData->name : $defaultName ?></span>
                    <span><?= $postData->createdAt ?></span>
                    <span>No. <?= $postData->id ?></span>
                </div>

                <div class="files <?= count($postData->fileInfos) === 1 ? "single" : "" ?>">
                    <?php foreach ($postData->fileInfos as $fileInfo): ?>
                        <figure class="file">
                            <figcaption>
                                <a class="file-url" href="<?= $fileInfo->url ?>"><?= $fileInfo->fileName ?></a>
                                <span class="file-size">(<?= $fileInfo->sizeStr ?>)</span>
                            </figcaption>
                            <div>
                                <img src="<?= $fileInfo->thumbUrl ?>">
                            </div>
                        </figure>
                    <?php endforeach; ?>
                </div>

                <div class="body">
                    <blockquote class="message-text">
                        <?= $postData->messageText ?>
                    </blockquote>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>