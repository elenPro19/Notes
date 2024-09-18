<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Путь для перенаправления после успешного входа.
    protected $redirectTo = '/notes';

    // Создаем новый экземпляр контроллера.
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    // Переопределяем метод login
    public function login(Request $request)
    {
        // Валидация входящих данных
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Проверка учетных данных
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->intended($this->redirectTo);
        }

        // Если пользователь не найден, отправляем пользователя обратно с ошибкой
        return back()->withErrors([
            'email' => 'Пользователь с такими учетными данными не найден',
        ]);
    }
}

