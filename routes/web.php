<?php

use App\Mail\SetPassword;
use App\Mail\TestEmail;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/send-test-email', function () {
    $toEmail = 'test@example.com';  // Replace with the email address you want to send to

    $user = User::find(2);
    $token = Password::broker()->createToken($user);


    $url = Filament::getResetPasswordUrl($token, $user);
    Mail::to($toEmail)->send(new SetPassword($url));

    return 'Test email sent successfully!';
});
