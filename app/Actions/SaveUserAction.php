<?php

namespace App\Actions;

use App\Actions\ShortenUrlHelper;
use App\Enums\StatusType;
use App\Models\User;

class SaveUserAction 
{
    public function __construct( public ShortenUrlHelper $shortenUrl) {
    }
    
    public function execute(User $user,array $data): User{

        $user->fill($data);
    
        $user->save();
        return  $user;
    
        
    }
}
