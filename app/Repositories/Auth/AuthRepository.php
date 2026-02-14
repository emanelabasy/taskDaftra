<?php
namespace App\Repositories\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;


class AuthRepository
{

    public function __construct(
        protected User   $model
    ){
    }

    public function login($input)
    {
        $user = $this->model->where('email', $input['email'])->first();

        if (!$user || !Hash::check($input['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials.'],
            ]);
        }

        $token = $user->createToken(
            $input['device_name'] ?? 'api',
            ['transfers:create', 'stock:update']
        )->plainTextToken;

        return [$user,$token];
    }

}