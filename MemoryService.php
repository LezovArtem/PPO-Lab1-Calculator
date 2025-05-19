<?php

class MemoryService
{
    private static float $memory = 0.0;

    public static function add(float $x): float {
        return self::$memory += $x;
    }

    public static function subtract(float $x): float {
        return self::$memory -= $x;
    }

    public static function recall(): float {
        return self::$memory;
    }

    public static function clear(): float {
        return self::$memory = 0.0;
    }
}
