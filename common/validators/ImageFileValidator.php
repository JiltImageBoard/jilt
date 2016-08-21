<?php

namespace app\common\validators;

use yii\validators\Validator;

class ImageValidator extends Validator
{
    /** @var array $params */
    public $params;

    public $wrongResolution;

    public function init()
    {
        parent::init();

        if ($this->wrongResolution === null) {
            $this->wrongResolution = Yii::t('yii', 'File "{file}" has wrong resolution. It should be between {minResolution} and {maxResolution}.');
        }
    }

    /**
     * @param string $filePath valid file path
     * @return array|null
     */
    protected function validateValue(string $filePath)
    {
        list($sourceWidth, $sourceHeight) = getimagesize($filePath);
        list($minWidth, $minHeight) = explode('x', $this->params['minImageResolution']);
        list($maxWidth, $maxHeight) = explode('x', $this->params['maxImageResolution']);
        if (
            $sourceWidth < $minWidth || $sourceHeight < $minHeight ||
            $sourceWidth > $maxWidth || $sourceHeight > $maxHeight
        ) {
            return [$this->wrongResolution, [
                'file' => $filePath,
                'minResolution' => $this->params['minImageResolution'],
                'maxResolution' => $this->params['maxImageResolution']
            ]];
        }

        return null;
    }
}