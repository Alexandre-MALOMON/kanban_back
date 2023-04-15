<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return response()->json([
            "status" => "success",
            'users' => $users,

        ]);
    }
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        /*   $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME); */
        $request->validate(
            [
                'name' => ['required', 'string', 'max:255', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => Rules\Password::defaults(),
            ],
        );


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Crypt::encrypt($request->password),

        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        event(new Registered($user));

        return response()->json([
            "status" => "success",
            'user' => $user,
            'token' => $token,
            "message" => "inscription réussie"
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required'],
        ]);

        $user = User::where("name", $request->name)->first();

        if (!$user || !Crypt::encrypt($request->password, $user->password)) {
            return response(
                [
                    'message' => 'Email ou Mot de passe incorrect'
                ],
                401
            );
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    public function logout(Request $request)
    {

        Auth::user()->tokens()->delete();
        return response()->json([
            "status" => "success",
            "message" => 'Déconnexion reussie',
        ]);
    }
}
