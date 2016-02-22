<?php

namespace app\models;

/**
 * Class PostData
 * @package app\models
 *
 * @property int $id
 * @property string $name
 * @property int $messageId
 * @property string $subject
 * @property int $ip
 * @property string $session
 * @property bool $isPremoded
 * @property bool $isModPost
 * @property bool $isDeleted
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 * relations
 * @property \app\models\Message $message
 */
class PostData extends ActiveRecordExtended
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return 'post_data';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessage()
    {
        return $this->hasOne(PostMessage::className(), ['id' => 'message_id']);
    }
}