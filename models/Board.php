<?php

namespace app\models;

/**
 * Class Board
 * @package app\models
 *
 * @property int $id
 * @property string $name
 * @property int $settingsId
 * @property string $description
 * @property \DateTime $createdAt
 * @property \DateTime $updatedAt
 *
 * @property \app\models\FileFormat[] $fileFormats
 * @property \app\models\WordFilter[] $wordFilters
 * @property-read \app\models\FileRating[] $fileRatings
 * @property-read \app\models\MarkupType[] $markupType
 * @property-read \app\models\Thread[] $threads
 * @property-read \app\models\BoardSettings $settings
 */

class Board extends ActiveRecordExtended
{
    /**
     * @var
     */
    protected $modelsToLink;

    /**
     * @return string
     */
    public static function tableName()
    {
        return 'boards';
    }


    /**
     * @return $this
     */
    public function getFileFormats()
    {
        return $this->hasMany(FileFormat::className(), ['id' => 'file_format_id'])
            ->viaTable('boards_file_formats', ['board_id' => 'id']);
    }

    /**
     * @param int[] $ids
     */
    public function setFileFormats($ids)
    {
        $this->addLazyRelation(FileFormat::className(), $ids, 'fileFormats');
    }

    /**
     * @return $this
     */
    public function getWordFilters()
    {
        return $this->hasMany(WordFilter::className(), ['id' => 'wordfilter_id'])
            ->viaTable('boards_wordfilters', ['board_id' => 'id']);
    }

    /**
     * @param int[] $ids
     */
    public function setWordFilters($ids)
    {
        $this->addLazyRelation(WordFilter::className(), $ids, 'wordFilters');
    }

    /**
     * @return $this
     */
    public function getFileRatings()
    {
        return $this->hasMany(FileRating::className(), ['id' => 'file_rating_id'])
            ->viaTable('boards_file_ratings', ['board_id' => 'id']);
    }

    /**
     * @return $this
     */
    public function getMarkupTypes()
    {
        return $this->hasMany(MarkupType::className(), ['id' => 'markup_type_id'])
            ->viaTable('boards_markup_types', ['board_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getThreads()
    {
        return $this->hasMany(Thread::className(), ['board_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSettings()
    {
        return $this->hasOne(BoardSettings::className(), ['id' => 'settings_id']);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['name', 'string', 'length' => [1, 255]]
        ];
    }

    //TODO: save не должен возвращаться void, так как в контроллере мы проверяем if ($board->save())
    /**
     * Overridden method handles setFileFormats method. Assigning ids to board in database
     * @param bool $runValidation
     * @param null $attributeNames
     * @return bool
     */
    public function save($runValidation = true, $attributeNames = null) {

        if (empty($this->lazyRelations)){
            return parent::save($runValidation, $attributeNames);
        } else {
            foreach ($this->lazyRelations as $modelClass => $relationInfo) {
                if (class_exists($modelClass)) {
                    $models = $modelClass::find()->where(['id' => $relationInfo['ids']])->all();
                    foreach ($models as $model) {
                        if ($model) {
                            $this->link($relationInfo['relationName'], $model);
                        }
                    }
                }
            }
            return parent::save($runValidation, $attributeNames);
        }

    }
}