<?php

namespace GlobeGroup\ApiTests\Assert;

class ArraySubset
{
    public static function arrayIntersectRecursive(array $arr1, array $arr2, bool $fullCheck)
    {
        $arrayResult = self::checkComplementary($arr1, $arr2, $fullCheck);
        print_r($arrayResult);
        if (empty($arrayResult)) {
            return false;
        }

        $result = true;
        array_walk_recursive($arrayResult, static function ($item) use (&$result) {
            if ($result && $item !== true) {
                $result = false;
            }
        });
        return $result;
    }

    private static function checkComplementary(&$arr1, &$arr2, bool $fullCheck)
    {
        if (!is_array($arr1) || !is_array($arr2)) {
            return (string)$arr1 === (string)$arr2;
        }

        $commonKeys = array_intersect(array_keys($arr1), array_keys($arr2));
        $ret = array();
        foreach ($commonKeys as $key) {
            $ret[$key] = self::checkComplementary($arr1[$key], $arr2[$key], $fullCheck);
            if ($fullCheck && array_diff(array_keys($arr1), array_keys($arr2))) {
                $ret[$key] = false;
            }
        }

        return $ret;
    }
}
