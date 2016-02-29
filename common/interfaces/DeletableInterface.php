<?php

namespace app\common\interfaces;

interface DeletableInterface {

    /**
     * @param array $carry contains associative array with ids of boards, threads, etc that will be deleted permanently
     * @return array
     */
    public function getDeletedRows(Array $carry);
}