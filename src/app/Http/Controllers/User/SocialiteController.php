<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Str;
use App\Http\Controllers\AppBaseController;
class SocialiteController extends AppBaseController
{

    public function __construct()
    {
    }
    
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        $getInfo = Socialite::driver($provider)->user(); 
        if($getInfo->getEmail()){
            $findUser = User::where('email', $getInfo->email)->first();
            if($findUser){

                if (! $token = auth('api')->setTTL(1800)->login($findUser)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                return $this->respondWithToken($token);

            } else {
                $user = new User();
                $user->email = $getInfo->getEmail();
            
                if(!$getInfo->getName()) $user->name = $getInfo->getNickname();
                else $user->name = $getInfo->getName();

                $user->provider_id = $getInfo->getId();
                $user->provider = $provider;
                $user->url = Str::random(15);

                $user->save();

                if (! $token = auth('api')->setTTL(1800)->login($user)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                return $this->respondWithToken($token);
            }
        } else {

            $user = User::where('provider_id', $getInfo->id)
                ->where('provider', $provider)
                ->first();
            if (!$user) {
                $user = new User();
                if(!$getInfo->getName()) $user->name = $getInfo->getNickname();
                else $user->name = $getInfo->getName();

                $user->provider_id = $getInfo->getId();
                $user->provider = $provider;
                $user->url = Str::random(15);

                $user->save();
            }
            
            if (! $token = auth('api')->setTTL(1800)->login($user)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->respondWithToken($token);
        }
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'current' => \Carbon\Carbon::now()->toDateTimeString()
        ]);
    }
}
