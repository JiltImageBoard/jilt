<?php

namespace app\services;

use app\models\ARExtended;
use app\models\Board;
use app\models\PostData;
use app\models\Thread;
use app\models\UploadForm;
use yii\base\Model;
use yii\base\UserException;
use yii\web\Response;

class ThreadService
{
    public static function create(string $boardName, array $data)
    {
        /** @var Board $board */
        if (!$board = Board::findOne(['name' => $boardName])) {
            throw new UserException('Board was not found', 404);
        }

        $validationParams = $board->postsSettings->getValidationParams();

        $thread     = new Thread(['boardId' => $board->id]);
        $postData   = new PostData(['validationParams' => $validationParams]);
        $uploadForm = new UploadForm([
            'files'            => PostedFile::getPostedFiles($validationParams['maxFiles']),
            'validationParams' => $validationParams
        ]);

        $toLoad = [$thread, $postData];
        $toValidate = [$thread, $postData, $uploadForm];

        if (!ARExtended::loadMultiple($toLoad, $data) || !Model::validateMultiple($toValidate)) {
            throw new UserException('Failed to load/validate data', 400);
        }

        if (strlen($postData->messageText) == 0 && count($uploadForm->files)) {
            throw new UserException('Must be attached atleast 1 file or non-empty message', 400);
        }

        $toSave = [$postData, $thread, $uploadForm];

        $postData->on(PostData::EVENT_AFTER_INSERT, function ($event) use ($thread) {
            $thread->postDataId = $event->sender->id;
        });

        $saved = true;
        foreach ($toSave as $model) {
            if (method_exists($model, 'save')) {
                $saved = $saved && $model->save();
                if (!$saved) break;
            }
        }

        if (!$saved) {
            for ($i = count($toSave) - 1; $i >= 0; $i--) {
                method_exists($toSave[$i], 'delete') && $toSave[$i]->delete();
            }

            throw new UserException('Failed to create thread', 500);
        }

        foreach ($uploadForm->getFileInfos() as $fileInfo) {
            $postData->link('fileInfos', $fileInfo);
        }

        $thread->link('board', $board);

        return $thread;
    }
}