<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        $this->request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $userAgent = $this
            ->request
            ->userAgent();

        $email = $this
            ->request
            ->email;

        $password = $this
            ->request
            ->password;

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'errors' => [
                    'login' => 'Email or password wrog.',
                ],
            ], 401);
        }

        $token = $user
            ->createToken($userAgent)
            ->plainTextToken;

        return response()->json([
            'type' => 'Bearer',
            'access_token' => $token,
        ]);
    }

    public function logout()
    {
        try {
            $this
                ->request
                ->user()
                ->currentAccessToken()
                ->delete();

            return response()->json([], 204);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }
}
