<?php

namespace App\Traits\Enum;

trait Compare
{
    public static function options()
    {
        $cases = static::cases();

        $options = [];

        foreach ($cases as $case) {
            $options[$case->value] = $case->value;
        }

        return $options;
    }

    public function equals(string | self $value): bool
    {
        if (is_string($value)) {
            return $this->value === $value;
        }

        return $this->value === $value->value;
    }

    public function notEquals(string | self $value): bool
    {
        if (is_string($value)) {
            return $this->value !== $value;
        }

        return $this->value !== $value->value;
    }
}
