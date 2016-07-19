<?php

namespace app\models;

/**
 * Class FileRating
 * @package app\models
 * @property string $ratingName
 * @property string $picturePath
 */
class FileRating extends ARExtended
{
    public static function tableName()
    {
        return 'file_ratings';
    }

}