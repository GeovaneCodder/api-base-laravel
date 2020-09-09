<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * Retorna os dados do usuário que efetuou
     * a requisição.
     * 
     * @return json
     */
    public function me()
    {
        $user = $this
            ->request
            ->user();

        return response()->json(new UserResource($user), 200);
    }

    /**
     * Cria um novo usário no banco de dados
     * 
     * @param $request App\Http\Requests\StoreUserRequest
     * @return json ou
     * @return \Exception
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->all();

        try {
            $user = User::create($data);
            $user
                ->profile()
                ->create([
                    'content' => $request->only(['first_name', 'last_name'])
                ]);

            return response()->json(new UserResource($user), 201);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }
}
