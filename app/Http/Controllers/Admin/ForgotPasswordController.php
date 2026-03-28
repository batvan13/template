<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => ['required', 'email']], [
            'email.required' => 'Въведете имейл адрес.',
            'email.email'    => 'Невалиден имейл адрес.',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Изпратихме линк за смяна на парола на посочения имейл.');
        }

        $errors = [
            Password::INVALID_USER    => 'Не намерихме потребител с този имейл.',
            Password::RESET_THROTTLED => 'Изчакайте малко преди да опитате отново.',
        ];

        return back()->withErrors([
            'email' => $errors[$status] ?? 'Нещо се обърка. Опитайте отново.',
        ]);
    }
}
