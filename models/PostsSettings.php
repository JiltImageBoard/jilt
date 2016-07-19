<?php
/**
 * Created by PhpStorm.
 * User: null
 * Date: 05.07.16
 * Time: 19:06
 */

namespace app\models;

/**
 * Class PostsSettings
 * @package app\models
 * @property int $minFileSize
 * @property int $maxFileSize
 * @property string $minImageResolution
 * @property string $maxImageResolution
 * @property int $maxFiles
 * @property string $maxMessageLength
 * relations
 * @property Board[] $boards
 * @property Thread[] $threads
 * @property WordFilter[] $wordFilters
 * @property MimeType[] $mimeTypes
 * @property MarkupType[] $markupTypes
 * @property FileRating[] $fileRatings
 */
class PostsSettings extends ARExtended
{
    public static function tableName()
    {
        return "posts_settings";
    }

    public function getBoards()
    {
        return $this->hasMany(Board::className(), ['posts_settings_id' => 'id']);
    }

    public function getThreads()
    {
        return $this->hasMany(Thread::className(), ['posts_settings_id' => 'id']);
    }

    public function getWordFilters()
    {
        return $this->hasMany(WordFilter::className(), ['id' => 'wordfilter_id'])
            ->viaTable('posts_settings_wordfilters', ['posts_settings_id' => 'id']);
    }

    public function getMimeTypes()
    {
        return $this->hasMany(MimeType::className(), ['id' => 'mime_type_id'])
            ->viaTable('posts_settings_mime_types', ['posts_settings_id' => 'id']);
    }

    public function getMarkupTypes()
    {
        return $this->hasMany(MarkupType::className(), ['id' => 'markup_type_id'])
            ->viaTable('posts_settings_markup_types', ['posts_settings_id' => 'id']);
    }

    public function getFileRatings()
    {
        return $this->hasMany(FileRating::className(), ['id' => 'file_rating_id'])
            ->viaTable('posts_settings_file_ratings', ['posts_settings_id' => 'id']);
    }
}