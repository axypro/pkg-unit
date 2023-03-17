<?php

declare(strict_types=1);

namespace axy\pkg\unit;

class ArrHelper
{
    public static function prepareActualForPartiallyComparison(
        array $expected,
        array $actual,
        bool $strict = true,
        bool $allowNull = false,
    ): array {
        $result = [];
        foreach ($expected as $k => $ev) {
            if (!array_key_exists($k, $actual)) {
                if ($allowNull) {
                    $result[$k] = null;
                }
                continue;
            }
            $av = $actual[$k];
            if (!$strict) {
                $av = self::convertWithoutStrict($ev, $av);
            }
            $result[$k] = $av;
        }
        return $result;
    }

    public static function prepareActualForItemsPartiallyComparison(
        array $expected,
        array $actual,
        bool $strict = true,
        bool $allowNull = false,
    ): array {
        $result = [];
        foreach ($expected as $k => $ev) {
            if (!array_key_exists($k, $actual)) {
                if ($allowNull) {
                    $result[$k] = null;
                }
                continue;
            }
            $av = $actual[$k];
            if (is_object($ev)) {
                $ev = (array)$ev;
            }
            if (is_object($av)) {
                $av = (array)$av;
            }
            if (is_array($av) && is_array($ev)) {
                $av = self::prepareActualForPartiallyComparison($ev, $av, $strict, $allowNull);
            } elseif (!$strict) {
                $av = self::convertWithoutStrict($ev, $av);
            }
            $result[$k] = $av;
        }
        foreach ($actual as $k => $av) {
            if (!array_key_exists($k, $result)) {
                if (($av !== null) || (!$allowNull)) {
                    $result[$k] = $av;
                }
            }
        }
        return $result;
    }

    private static function convertWithoutStrict(mixed $expected, mixed $actual): mixed
    {
        if (is_int($expected) && is_bool($actual)) {
            return $actual ? 1 : 0;
        }
        if (is_int($actual) && is_bool($expected)) {
            return (bool)$actual;
        }
        if (is_string($expected) && is_int($actual)) {
            return (string)$actual;
        }
        if (is_int($expected) && is_string($actual)) {
            $int = (int)$actual;
            if ((string)$int === $actual) {
                return $int;
            }
            return $actual;
        }
        return $actual;
    }
}
