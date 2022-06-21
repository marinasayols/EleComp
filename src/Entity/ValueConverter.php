<?php

namespace App\Entity;

class ValueConverter
{
    protected $reference = [
        'p' => -12,
        'n' => -9,
        'u' => -6,
        'm' => -3,
        'k' => 3,
        'M' => 6,
        'G' => 9,
    ];

    public function getValue($s_value)
    {
        $prefix = preg_replace('/\d+/', '', $s_value);
        if (strlen($prefix) > 1) {
            throw new \InvalidArgumentException('Value is not a number.');
        }
        $value = preg_replace('/[a-z]+/i', '.', $s_value);
        if (array_key_exists($prefix, $this->reference)) {
            return floatval($value) * (10 ** $this->reference[$prefix]);
        }
        return floatval($value);

    }
}

