<?php

namespace Application\Utils;

class HashGenerator
{
    /**
     * @param int $hashByteLength
     * @return string the SHA1 hash of a randomized 128 byte (default byte length) string (0-9, a-Z)
     * @throws \Exception
     */
    public static function randomizedShaByteHash($hashByteLength = 128)
    {
        $stringBuilder = '';

        for($i = 0; $i < $hashByteLength; $i++)
        {
            $stringBuilder .= self::generateRandomByteAlphaNumericCharacter();
        }

        return sha1($stringBuilder);
    }

    /**
     * @return string
     * @throws \Exception generate only alphanumeric characters ( ASCII code range in statement )
     */
    protected static function generateRandomByteAlphaNumericCharacter()
    {
        $byte = random_bytes(1);
        $byteToDecimal = ord($byte);
        if(($byteToDecimal >= 48 && $byteToDecimal <= 57)  ||
           ($byteToDecimal >= 65 && $byteToDecimal <= 90)  ||
           ($byteToDecimal >= 97 && $byteToDecimal <= 122))
            return chr($byteToDecimal);
        else
            return self::generateRandomByteAlphaNumericCharacter();
    }

    private const PBKDF2_HASH_ALGORITHM = "sha256";
    private const PBKDF2_ITERATIONS = 64000;
    private const PBKDF2_HASH_LENGTH = 64;
    private const PBKDF2_SALT_BYTES_LENGTH = 64;

    /**
     * @param $initialString (string that needs to be hashed)
     * @return array containing the BASE64 encoded hash and salt result['salt'], result['password']
     * @throws \Exception
     */
    public static function hashString($initialString)
    {
        $salt = random_bytes(self::PBKDF2_SALT_BYTES_LENGTH);
        $hash = hash_pbkdf2(self::PBKDF2_HASH_ALGORITHM, $initialString, $salt, self::PBKDF2_ITERATIONS, self::PBKDF2_HASH_LENGTH);

        $salt = base64_encode($salt);
        $hash = base64_encode($hash);

        return compact('salt', 'hash');
    }

    public static function validateHash($originalSalt, $initialString, $originalHash)
    {
        $hash = hash_pbkdf2(self::PBKDF2_HASH_ALGORITHM, $initialString, $originalSalt, self::PBKDF2_ITERATIONS, self::PBKDF2_HASH_LENGTH);

        if(hash_equals($hash,$originalHash))
            return true;
        else
            return false;
    }
}