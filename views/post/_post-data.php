<?php

use app\assets\PostsAssets;
use app\models\PostData;
use app\models\FileInfo;

/** @var PostData $postData */

PostsAssets::register($this);
?>

<div>
    <div class="post">
        <div class="header">
            <span class="subject"><?= $postData->subject ?></span>
            <span><?= $postData->getName() ?></span>
            <span><?= $postData->getCreatedAt() ?></span>
            <span>No. <?= $postData->id ?></span>
        </div>

        <div class="files <?= count($postData->fileInfos) === 1 ? "single" : "" ?>">
            <?php foreach ($postData->fileInfos as $fileInfo): ?>
                <?php /** @var FileInfo $fileInfo */ ?>

                <figure class="file">
                    <figcaption>
                        <a class="file-url" href="<?= $fileInfo->getUrl() ?>"><?= $fileInfo->fileName ?></a>
                        <span class="file-size">(<?= $fileInfo->getSizeStr() ?>)</span>
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
