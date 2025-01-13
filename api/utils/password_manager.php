<?php
class PasswordManager {
    public static function createPasswordHash($password) {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    public static function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
}
