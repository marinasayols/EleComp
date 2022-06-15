<?php

namespace App\Entity;

class Filter
{
    private $field;
    private $value;

    public function getField()
    {
        return $this->field;
    }

    public function setField($field): void
    {
        $this->field = $field;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

}