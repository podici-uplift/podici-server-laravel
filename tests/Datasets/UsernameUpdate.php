<?php

class UsernameUpdateDataSets
{
    const INVALID_USERNAMES = "username-update-invalid-usernames";
    const VALID_USERNAMES = "username-update-valid-usernames";
}

dataset(UsernameUpdateDataSets::INVALID_USERNAMES, function () {
    return [
        'i contain spaces',
        'IHaveSpecialCharacters#',
        '1startWithNumber',
        'IAmWayTooLongLikeIShouldBeWayTooLongLikeWhoWouldEvenReadThis'
    ];
});

dataset(UsernameUpdateDataSets::VALID_USERNAMES, function () {
    return [
        'YoungMayor',
        'Young.Mayor',
        'Young_Mayor',
        'YoungMayor123',
        'YoungMayor___'
    ];
});
