<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Traits\ApiResponse;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponse;
    


    function signup(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $defaultRole = Role::where('name', 'user')->first();
        if ($defaultRole) {
            $user->roles()->syncWithoutDetaching([$defaultRole->id]);
        }
        return $this->success($user->load('roles'), 'Usuario creado correctamente', 201);
    }

    /**
     * Autentica un usuario y devuelve un token de acceso.
     */
    public function login(LoginRequest $request)
    {
        // La validación se ejecuta automáticamente gracias a LoginRequest
        $credentials = $request->validated();

        // Intentamos autenticar al usuario
        if (!Auth::attempt($credentials)) {
            // Si las credenciales no son correctas, devolvemos un error 401
            return $this->error('Credenciales inválidas. Por favor, verifica tu correo y contraseña.', 401);
        }

        // Si la autenticación es exitosa, obtenemos el usuario
        $user = Auth::user();
        
        // Creamos un nuevo token para el usuario
        $token = $user->createToken('api-token')->plainTextToken;

        // Devolvemos la respuesta exitosa con el token y los datos del usuario
        return $this->success([
            'token_type' => 'Bearer',
            'access_token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                // Es muy útil devolver los roles para que el frontend sepa qué puede hacer el usuario
                'roles' => $user->roles()->pluck('name'),
            ]
        ], 'Inicio de sesión exitoso.');
    }

}
