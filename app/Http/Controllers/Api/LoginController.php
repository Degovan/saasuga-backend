<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\Api\FailedValidation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProviderRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    use ApiResponser;

    public function redirectToProvider(ProviderRequest $request, $provider)
    {
        $request->validateProvider($provider);
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return $this->success(
            ['redirect_url' => $url],
            'Success getting redirect url'
        );
    }

    public function handleProviderCallback(ProviderRequest $request, $provider)
    {
        $request->validateProvider($provider);

        try {
            $user = Socialite::driver($provider)->stateless()->user();
        } catch (ClientException) {
            throw new FailedValidation(['error' => 'Invalid credential providers']);
        }

        $userCreated = User::firstOrCreate(
            ['email' => $user->getEmail()],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
            ]
        );

        $userCreated->providers()->updateOrCreate(
            ['provider' => $provider, 'provider_id' => $user->getId()],
            ['avatar' => $user->getAvatar()]
        );

        $token = $userCreated->createToken('login-token')->plainTextToken;

        return $this->success(
            ['user' => $userCreated, 'access_token' => $token],
            'Login successfully'
        );
    }
}
