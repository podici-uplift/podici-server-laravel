<?php

dataset('profile-update-form-errors', fn() => [
    'phone_incorrect' => ['phone', 'xxxyyy'],

    'first_name_too_short' => ['first_name', 'F'],
    'first_name_has_spaces' => ['first_name', 'Foo Bar'],
    'first_name_too_long' => ['first_name', 'Firstnameshouldnotbethislongforrealyouknow'],
    'first_name_contains_at' => ['first_name', 'First@'],

    'last_name_too_short' => ['last_name', 'B'],
    'last_name_has_spaces' => ['last_name', 'Foo Bar'],
    'last_name_too_long' => ['last_name', 'Lastnameshouldnotbethislongforrealyouknow'],
    'last_name_contains_dot' => ['last_name', 'Last.'],

    'other_names_too_short' => ['other_names', 'O'],
    'other_names_way_too_long' => ['other_names', 'I am a very very very very very very very very long other name'],

    'gender_doesnt_exist' => ['gender', 'oops'],
]);
