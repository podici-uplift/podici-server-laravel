<?php

use App\Logics\RequirementBuilder;

test("It builds requirement correctly", function () {
    $fields = ['name', 'age', 'gender'];

    $requirementBuilder = new RequirementBuilder($fields);

    expect($requirementBuilder->requiredWithoutAll('name'))->toBe(
        "required_without_all:age,gender"
    );

    expect($requirementBuilder->requiredWithoutAll('age'))->toBe(
        "required_without_all:name,gender"
    );

    expect($requirementBuilder->requiredWithoutAll('gender'))->toBe(
        "required_without_all:name,age"
    );

    expect($requirementBuilder->requiredWithout('name'))->toBe(
        "required_without:age,gender"
    );

    expect($requirementBuilder->requiredWithout('age'))->toBe(
        "required_without:name,gender"
    );

    expect($requirementBuilder->requiredWithout('gender'))->toBe(
        "required_without:name,age"
    );
});
