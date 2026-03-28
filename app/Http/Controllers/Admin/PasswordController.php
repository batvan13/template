<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('admin.password.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password'      => ['required'],
            'new_password'          => ['required', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Въведете текущата парола.',
            'new_password.required'     => 'Въведете новата парола.',
            'new_password.min'          => 'Новата парола трябва да е поне 8 символа.',
            'new_password.confirmed'    => 'Потвърждението не съвпада.',
        ]);

        if (! Hash::check($request->current_password, $request->user()->password)) {
            return back()->withErrors(['current_password' => 'Текущата парола е грешна.']);
        }

        $request->user()->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Паролата е сменена успешно.');
    }
}
