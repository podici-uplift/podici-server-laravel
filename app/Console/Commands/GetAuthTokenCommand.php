<?php

namespace App\Console\Commands;

use App\Actions\AuthActions;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;

class GetAuthTokenCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-auth-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get auth token for local development';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = text(
            "User email:",
            default: "youngmayor.dev@gmail.com",
            required: true
        );

        $createIfMissing = confirm("Create user if missing");

        $user = $createIfMissing
            ? AuthActions::getOrCreateUserUsingEmail($email)
            : User::byIdentifier($email);

        if (!$user) return error("User with email {$email} was not found");

        $token = $user->createToken("Token from CLI");

        info("Token generated successfully: {$token->plainTextToken}");
    }
}
