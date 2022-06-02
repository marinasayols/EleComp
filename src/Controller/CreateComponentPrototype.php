<?php

namespace App\Controller;

use App\Entity\Component;

class CreateComponentPrototype
{
    private Component $_prototypeComponent;

    public function __construct(Component $component)
    {
        $this->_prototypeComponent = $component;
    }

    public function createComponent(Component $component) {
        return clone $this->_prototypeComponent;
    }
}