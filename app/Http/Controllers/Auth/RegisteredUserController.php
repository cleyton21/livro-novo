<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {   
        // dd($request);
        $request->validate([
            'postograd' => [
                'required',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('postograd', $request->postograd)
                                 ->where('nome_guerra', $request->nome_guerra);
                }),
            ],
            'nome_guerra' => ['required', 'string', 'max:255'],
            'nome_completo' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'cel' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'postograd' => $request->postograd,
            'nome_guerra' => $request->nome_guerra,
            'nome_completo' => $request->nome_completo,
            'email' => $request->email,
            'cel' => $request->cel,
            'perfil' => "Usuário Comum",
            'status' => 0,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}
