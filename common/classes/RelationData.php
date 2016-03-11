<?php

namespace app\common\classes;

class RelationData
{
    public $name;
    public $method;
    public $isMultiple;
    public $modelClass;
    public $link;
    public $via;

    public function __construct($name, $method, $isMultiple, $modelsClass, $link, $via)
    {
        $this->name = $name;
        $this->method = $method;
        $this->isMultiple = $isMultiple;
        $this->modelClass = $modelsClass;
        $this->link = $link;
        $this->via = $via;
    }
}