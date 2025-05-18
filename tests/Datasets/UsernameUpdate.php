<?php

namespace Tests\Datasets;

class UsernameUpdateDataSets
{
    static public function invalidUsernames()
    {
        return [
            'i contain spaces',
            'IHaveSpecialCharacters#',
            '1startWithNumber',
            'IAmWayTooLongLikeIShouldBeWayTooLongLikeWhoWouldEvenReadThis'
        ];
    }

    static public function validUsernames()
    {
        return [
            'YoungMayor',
            'Young.Mayor',
            'Young_Mayor',
            'YoungMayor123',
            'YoungMayor___'
        ];
    }
}
