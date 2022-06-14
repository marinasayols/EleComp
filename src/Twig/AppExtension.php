<?php

namespace App\Twig;

use App\Entity\Component;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('attributes', [$this, 'getAttributes']),
        ];
    }

    public function getAttributes(Component $component)
    {
        return null;
    }
}