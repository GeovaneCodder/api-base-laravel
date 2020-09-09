<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    /**
     * Faz a auteticação e gera um token de acesso
     * para o usuário.
     * @param $request App\Http\Requests\LoginRequest
     * @return json
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'errors' => [
                    'login' => _('auth.failed'),
                ],
            ], 401);
        }

        if (null === $user->email_verified_at) {
            return response()->json([
                'errors' => [
                    'email' => _('auth.unverified_email'),
                ],
            ], 403);
        }

        $token = $user
            ->createToken($request->userAgent())
            ->plainTextToken;

        return response()->json([
            'type' => 'Bearer',
            'access_token' => $token,
        ]);
    }

    /**
     * Revoga o token atual da requisição
     * @return json ou
     * @return \Exception
     */
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
