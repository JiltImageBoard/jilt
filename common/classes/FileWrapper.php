<?php

namespace app\common\classes;

use yii\base\Object;

/**
 * Simple wrapper used for absctraction of whether file is uploaded or already exists
 * Class FileWrapper
 * @package app\common\classes
 */
class FileWrapper extends Object
{
    /**
     * @var UploadedFile
     */
    public $uploadedFile;

    /**
     * @var string
     */
    public $fileHash;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @param int $filesCount
     * @param array $data
     * @return FileWrapper[]
     */
    public static function getLoadedFiles($filesCount, $data)
    {
        $files = [];
        for ($i = 0; $i < $filesCount; $i++) {
            $uploadedFile = UploadedFile::getInstanceByName("file-{$i}");
            if ($uploadedFile) {
                $files[] = new FileWrapper(['uploadedFile' => $uploadedFile]);
            } elseif ($data && isset($data["file-{$i}"])) {
                $files[] = new FIleWrapper(['fileHash' => $data["file-{$i}"]]);
            }
        }

        return $files;
    }
}