<?php

namespace app\common\classes;

class Date
{
    /**
     * @var \DateTime
     */
    private $dateTime;

    public function __construct(string $timestamp)
    {
        $this->dateTime = new \DateTime($timestamp);
    }
}