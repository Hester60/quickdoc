<?php

namespace App\DoctrineType;

use App\Enum\HexaColor;

class ColorType extends AbstractEnumType
{
    public const NAME = 'color';

    public function getName(): string // the name of the type.
    {
        return self::NAME;
    }

    public static function getEnumsClass(): string // the enums class to convert
    {
        return HexaColor::class;
    }
}
