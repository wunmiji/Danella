<?php 

namespace App\Libraries;
/**
 * 
 */
class PasswordLibrary {
	
	public static function encrypt ($password) {
        $options = [
            'cost' => 15,
        ];
        return password_hash($password, PASSWORD_BCRYPT, $options);
    }

    public static function check ($password, $hash) {
        return password_verify($password, $hash);
    }

    public static function salt16 () {
        return bin2hex(random_bytes(16));
    }
}