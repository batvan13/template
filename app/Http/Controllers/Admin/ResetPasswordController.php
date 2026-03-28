<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, string $token)
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'email.required'     => 'Въведете имейл адрес.',
            'email.email'        => 'Невалиден имейл адрес.',
            'password.required'  => 'Въведете нова парола.',
            'password.min'       => 'Паролата трябва да е поне 8 символа.',
            'password.confirmed' => 'Потвърждението не съвпада.',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password'       => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('admin.login')
                ->with('success', 'Паролата е сменена успешно. Влезте с новата парола.');
        }

        $errors = [
            Password::INVALID_TOKEN => 'Линкът е невалиден или е изтекъл. Заявете нов.',
            Password::INVALID_USER  => 'Не намерихме потребител с този имейл.',
        ];

        return back()->withErrors([
            'email' => $errors[$status] ?? 'Нещо се обърка. Опитайте отново.',
        ]);
    }
}
