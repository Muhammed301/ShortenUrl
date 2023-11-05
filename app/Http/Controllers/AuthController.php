<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProvider;
use Illuminate\Http\Request;
use App\Actions\SaveUserAction;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    //
    public function __construct( 
        public SaveUserAction  $saveUserAction
    ) {
    }

    public function authenticate_user(){
        $githubUser = Socialite::driver('github')->user();
        $user = User::where('email',$githubUser->email)->first();
        if(!$user){
            $data = [
                'email' => $githubUser->email,
                'first_name' => $githubUser->name,
            ];
        $user = $this->saveUserAction->execute(new User(), $data);
        }
        
        $user_provider = UserProvider::updateOrCreate([
            'user_id' => $user->id,
        ], [
            'provider' => 'github',
            'provider_token' => $githubUser->token,
        ]);

        Auth::login($user);

        return redirect('dashboard');
    }
   
}
