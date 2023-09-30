<?php

namespace App\Http\Controllers\Actions;

use App\Models\Url;
use App\Enums\Status;

class SaveUrl 
{

    
    public function execute($validated, $url){

        // if($url){

        //     $url->original_url = $validated['original_url'];

        // }else{
            $validated['shorten_url'] =$url->shorten_url ?? ENV('APP_URL').'/'. base_convert($validated['original_url'],16,8);
            $url->original_url = $validated['original_url'];
            $url->shorten_url = $validated['shorten_url'];
            $url->status = $validated['status'] ?? Status::Active;  
        // }
        $url->save();
        return $url;
    }
}
