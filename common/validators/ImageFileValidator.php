<?php

namespace app\common\validators;

use yii\validators\Validator;

class ImageFileValidator extends Validator
{
    /** @var array $params */
    public $params;

    /** @var string message on wrong image resolution */
    public $wrongResolution;

    /**
     * Image resolutions in format "{width}x{height}"
     */
    /** @var string $maxImageResolution */
    public $maxImageResolution;

    /** @var string $minImageResolution */
    public $minImageResolution;

    public function init()
    {
        parent::init();

        if (!empty($this->params)) {
            foreach ($this->params as $prop => $value) {
                if (property_exists($this, $prop)) {
                    $this->$prop = $value;
                }
            }
        }

        if ($this->wrongResolution === null) {
            $this->wrongResolution = \Yii::t('yii', 'File "{file}" has wrong resolution. It should be between {minResolution} and {maxResolution}.');
        }
    }

    /**
     * @param string $filePath valid file path
     * @return array|null
     */
    public function validateValue($filePath)
    {
        list($sourceWidth, $sourceHeight) = getimagesize($filePath);
        list($minWidth, $minHeight) = explode('x', $this->minImageResolution);
        list($maxWidth, $maxHeight) = explode('x', $this->maxImageResolution);
        if (
            $sourceWidth < $minWidth || $sourceHeight < $minHeight ||
            $sourceWidth > $maxWidth || $sourceHeight > $maxHeight
        ) {
            return [$this->wrongResolution, [
                'file' => $filePath,
                'minResolution' => $this->minImageResolution,
                'maxResolution' => $this->maxImageResolution
            ]];
        }

        return null;
    }
}