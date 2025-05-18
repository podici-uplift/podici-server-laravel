<?php

class PasswordUpdateDataSets
{
    static public function invalidPasswords()
    {
        return [
            'password',
            'passwordwithnothing',
            'passwordwithnumberonly1',
            'passwordwithsymbolonly@',
            'passwordwithonlysymbolandnumber1@#',
            'PASSWORDWITHONLYCAPSSYMBOLSANDNUMBERS1@#'
        ];
    }

    static public function validPasswords()
    {
        return [
            'I am a secure password123#',
            'I @m @ v3r9 s3c8r3 p@55w07d',
            '1 coo2 passwor3.YYY'
        ];
    }
}
