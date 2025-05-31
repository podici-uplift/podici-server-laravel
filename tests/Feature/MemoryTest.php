<?php

use App\Models\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

describe("All Memory Test", function () {
    memoryBoxAction(function () {
        fake()->paragraph();
    }, "Fake Paragraph");

    memoryBoxAction(function () {
        fake()->paragraphs();
    }, "Fake Paragraphs");

    memoryBoxAction(function () {
        fake()->sentence();
    }, "Fake Sentence");

    memoryBoxAction(function () {
        fake()->sentences();
    }, "Fake Sentences");

    memoryBoxAction(function () {
        fake()->realText();
    }, "Fake RealText");

    memoryBoxAction(function () {
        User::factory()->create();
    }, "User Creation");

    memoryBoxAction(function () {
        $password = uniqid();

        $passwordHash = Hash::make($password);

        Hash::check($password, $passwordHash);
    }, "Hash");

    memoryBoxAction(function () {
        $password = uniqid();

        $passwordEncrypted = Crypt::encrypt($password);

        $decryptedPassword = Crypt::decrypt($passwordEncrypted);
    }, "Encryption");

    memoryBoxAction(function () {
        Log::info("Test");
    }, "Log");

    memoryBoxAction(function () {
        $users = User::get();
    }, "Get all users");

    memoryBoxAction(function () {
        $sum = 9999 * 999999;
    }, "Sum");

    memoryBoxAction(function () {
        $array = [1, 2];

        $sum = array_sum($array);

        $count = count($array);

        array_push($array, 3);
    }, "Array");
});

function memoryBoxAction(Closure $action, string $title)
{
    it("$title", function () use ($action, $title) {
        memory_reset_peak_usage();

        $startMemory = memory_get_peak_usage(true);

        $action();

        $endMemory = memory_get_peak_usage(true);

        $usedMemory = ($endMemory - $startMemory) / 1024 / 1024;

        fwrite(STDOUT, sprintf(
            "\n%.2f MB - $title - Peak Memory: %.2f MB",
            $usedMemory,
            memory_get_peak_usage(true) / 1024 / 1024
        ));

        expect(1)->toBe(1);
    });
}
