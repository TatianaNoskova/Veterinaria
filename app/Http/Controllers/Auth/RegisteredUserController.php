<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;  // Модель для пользователя
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): \Illuminate\View\View
    {
        return view('auth.custom_registro'); // custom Blade
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Валидация только для email и пароля
        $request->validate([
            'correo_electronico' => ['required', 'string', 'email', 'max:255', 'unique:usuario,correo_electronico'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        // Создание нового пользователя в таблице usuario
         $usuario = Usuario::create([
            'correo_electronico' => $request->correo_electronico,
            'password' => Hash::make($request->password),
            'rol' => 'cliente',  // роль по умолчанию
            'nombre' => '',       // Пустое значение для имени
            'apellido' => '',     // Пустое значение для фамилии
            'dni' => '',          // Пустое значение для DNI
        ]);

        // Регистрация и логин нового пользователя
        event(new Registered($usuario));  // Триггерим событие после регистрации
        Auth::login($usuario);  // Автоматический вход в систему

        // Перенаправление на страницу клиента (или на роль по умолчанию)
        return redirect()->route('user.dashboard');  // Перенаправление на страницу после успешной регистрации
    }
}


