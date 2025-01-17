<?php

namespace App\Enums;

enum FileType : string {

    case PRIVATE = 'Private';
    case PUBLIC = 'Public';


    public static function getValue($arg) {
        $enumsArr = FileType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	if ($name == $arg) return $values[$key];
        }

        return null;
    }


    public static function getAll(): array {
        $types = array();
        $enumsArr = FileType::cases();
        $names = array_column($enumsArr, 'name');
        $values = array_column($enumsArr, 'value');

        foreach ($names as $key => $name) {
        	$types[$name] = $values[$key];
        }

        return $types;

    }
    
}