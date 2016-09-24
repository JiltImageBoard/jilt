<?php

namespace app\common\classes;

class Date
{
    /** @var \DateTime */
    private $dateTime;

    /** @var integer|string */
    private $timestamp;

    public function __construct(string $timestamp)
    {
        $this->dateTime = new \DateTime($timestamp);
    }

    public function getDayOfWeekStr()
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return $days[idate('w', $this->timestamp) + 1];
    }

    public function __toString()
    {
        return $this->getDayOfWeekStr() . ' ' . $this->dateTime->format('Y-m-d H:i:s');
    }
}