<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Mail\SetPassword;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Mail;
use App\Filament\Resources\UserResource;
use Illuminate\Support\Facades\Password;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Auth\ResetPassword as ResetPasswordNotification;


class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function afterCreate(): void
    {
        $user = $this->getRecord();
        $token = Password::broker()->createToken($user);

        // Need to change for UserPanel
        $url = Filament::getResetPasswordUrl($token, $user);
        Mail::to($user->email)->send(new SetPassword($url));
    }
}
