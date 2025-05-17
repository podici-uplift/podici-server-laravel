<?php

describe("Update Password", function () {
    $baseTester = fn() => httpTester('POST', 'api.auth.user.password-update');
});
