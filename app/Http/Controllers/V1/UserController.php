<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function me()
    {
        $user = $this
            ->request
            ->user();

        return response()->json(new UserResource($user), 200);
    }

    public function store()
    {
        $this
            ->request
            ->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'first_name' => 'required|string',
                'last_name' => 'required|string',
            ]);

        $data = $this
            ->request
            ->all();

        try {
            $user = User::create($data);
            $user
                ->profile()
                ->create([
                    'content' => $this
                        ->request
                        ->only(['first_name', 'last_name'])
                ]);

            return response()->json(new UserResource($user), 201);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }
}
