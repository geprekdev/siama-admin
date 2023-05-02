<?php

use Illuminate\Support\Str;

if (!function_exists('django_password_verify')) {
    /**
     * Verify a Django password (PBKDF2-SHA256)
     *
     * @ref http://stackoverflow.com/a/39311299/2224584
     * @param string $password   The password provided by the user
     * @param string $djangoHash The hash stored in the Django app
     * @return bool
     * @throws Exception
     */
    function django_password_verify(string $password, string $djangoHash): bool
    {
        $pieces = explode('$', $djangoHash);
        if (count($pieces) !== 4) {
            return false;
        }
        list($header, $iter, $salt, $hash) = $pieces;
        // Get the hash algorithm used:
        if (preg_match('#^pbkdf2_([a-z0-9A-Z]+)$#', $header, $m)) {
            $algo = $m[1];
        } else {
            return false;
        }
        if (!in_array($algo, hash_algos())) {
            return false;
        }

        $calc = hash_pbkdf2(
            $algo,
            $password,
            $salt,
            (int) $iter,
            32,
            true
        );
        return hash_equals($calc, base64_decode($hash));
    }
}

if (!function_exists("django_password_hash")) {
    /**
     * Hash password to Django style (PBKDF2-SHA256)
     *
     * @param string $password  The password provided by the user
     */
    function django_password_hash(string $password): string {
        $algo = 'sha256';
        $iterations = 260000;
        $salt = Str::random(22);

        $hash = base64_encode(hash_pbkdf2($algo, $password, $salt, $iterations, 32, true));

        return implode('$', [
           'pbkdf2_' . $algo,
           $iterations,
           $salt,
           $hash
        ]);
    }
}
