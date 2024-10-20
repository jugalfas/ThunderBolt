<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Password;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function afterCreate(): void
    {
        $records = $this->getRecord();
        $status = Password::sendResetLink(['email' => $records->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('success', __('Password reset link sent on registered email.'));
        } else {
            session()->flash('error', __('Unable to send password reset link.'));
        }
    }
}
