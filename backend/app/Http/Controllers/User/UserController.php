<?php

namespace App\Http\Controllers\User;

final class UserController
{
    /**
     * Страница профиля
     */
    public function index()
    {
        return view('dashboard');
    }
}
