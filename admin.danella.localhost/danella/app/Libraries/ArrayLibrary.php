<?php

namespace App\Libraries;


/**
 * 
 */
class ArrayLibrary
{

    // get idArray from multidimensional array
    public static function getIdArray($row)
    {
        $valueArray = array();

        foreach ($row as $key => $value) {
            foreach ($value as $keyy => $valuee) {
                array_push($valueArray, $valuee);
            }
        }


        return $valueArray;
    }

    // get idArray from multidimensional array
    public static function getColumnArray($array, $columnName)
    {
        $valueArray = array();

        foreach ($array as $key => $value) {
            foreach ($value as $keyy => $valuee) {
                if ($keyy == $columnName) {
                    array_push($valueArray, $valuee);
                }
            }
        }


        return $valueArray;
    }

    public static function arrayContains($array, $link)
    {
        $valueArray = array();
        foreach ($array as $key => $value) {
            if (str_contains($value, $link)) {
                $valueArray[$key] = $value;
            }
        }

        return $valueArray;
    }

    public static function getOneToManyy($arrayOne, $arrayTwo)
    {
        if (empty($arrayOne))
            return null;
        else {
            $valueArray = array();
            foreach ($arrayOne as $value) {
                if (!in_array($value, $arrayTwo)) {
                    array_push($valueArray, $value);
                }
            }

            return $valueArray;
        }
    }

    public static function getOneToMany($arrayOne, $arrayTwo)
    {
        $valueArray = array();
        foreach ($arrayOne as $value) {
            if (!in_array($value, $arrayTwo)) {
                array_push($valueArray, $value);
            }
        }

        return $valueArray;
    }

    public static function arrayMerge($array1, $array2)
    {
        $result = array_map(function ($array1, $array2) {

            return array_merge(isset ($array1) ? $array1 : array (), isset ($array2) ? $array2 : array ());

        }, $array1, $array2);

        return $result;
    }

}