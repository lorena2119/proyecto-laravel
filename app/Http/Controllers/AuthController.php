<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Lesson;
use App\Traits\ApiResponse;
use App\Models\LessonAssignment;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Registered;

class AuthController extends Controller
{
    use ApiResponse;
    


    public function signup(Request $request)
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
        if (!$defaultRole) {
            return $this->error('Rol por defecto no encontrado', 500);
        }
        $user->roles()->syncWithoutDetaching([$defaultRole->id]);

        // Asignar lección automática al registro (primera vez)
        $this->assignInitialLesson($user);

        // event(new Registered($user)); // Para futuras ocasiones-------
 
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'user' => $user->load('roles'),
            'token' => $token
        ], 'Usuario creado correctamente', 201);
    }

    // Método privado para asignar lección inicial
    protected function assignInitialLesson(User $user)
    {
        // Verificar si el usuario ya tiene una asignación (por si acaso)
        if ($user->lessonAssignments()->exists()) {
            return; // No asignar si ya tiene
        }

        // Seleccionar una lección diaria (is_daily = true), o la primera si no hay
        $lesson = Lesson::where('is_daily', true)->inRandomOrder()->first();
        if (!$lesson) {
            $lesson = Lesson::first(); // Fallback a la primera lección disponible
        }

        if ($lesson) {
            LessonAssignment::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'assigned_at' => now(),
            ]);
        }
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
        $user = Auth::user()->load('roles');
        
        // Creamos un nuevo token para el usuario
        $token = $user->createToken('api-token')->plainTextToken;

        // Devolvemos la respuesta exitosa con el token y los datos del usuario
        $loginData = (new LoginResource ($user))
                        ->additional([
                            'meta' => [
                                'token_access' => 'Bearer',
                                'access_token' => $token,
                            ]
                        ]);

        return $this->success($loginData, 'Inicio de sesión exitoso.');
    }

}
