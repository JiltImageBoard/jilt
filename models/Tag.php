<?php

namespace app\models;

/**
 * Class Tag
 * @package app\models
 * 
 * @property int $id
 * @property string $name
 * 
 * @property \app\models\Thread $threads
 */
class Tag extends ActiveRecordExtended
{
    public static function tableName()
    {
        return 'tags';
    }
    
    public static function parseTags($message)
    {
        $matches = [];
        $regexp = "/((?<=#)[a-zA-Z]{1,50})/";
        if (preg_match_all($regexp, $message, $matches)) {
            $models = [];
            foreach ($matches[0] as $tagElement) {
                $tag = new Tag();
                $tag->name = $tagElement;
                $tag->save();
                $models[] = $tag;
            }
          return $models;  
        } 
        return false;
    }
    
    public function getThreads()
    {
        return $this->hasMany(Thread::className(), ['id' => 'thread_id'])
            ->viaTable('threads_tags', ['tag_id' => 'id']);
    }
}