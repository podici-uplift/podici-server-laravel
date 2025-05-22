<?php

namespace Tests\Datasets;

class UsernameUpdateDatasets
{
    public static function invalidUsernames()
    {
        return [
            'i contain spaces',
            'IHaveSpecialCharacters#',
            '1startWithNumber',
            'IAmWayTooLongLikeIShouldBeWayTooLongLikeWhoWouldEvenReadThis',
        ];
    }

    public static function validUsernames()
    {
        return [
            'YoungMayor',
            'Young.Mayor',
            'Young_Mayor',
            'YoungMayor123',
            'YoungMayor___',
        ];
    }
}
