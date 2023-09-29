<?php

namespace App\Http\Controllers\Actions;

use App\Models\Url;
use App\Enums\Status;

class CreateUrl 
{
    //

    public function get_all(){
        $urls = Url::all();
        return $urls;
    }

    
    public function save($validated){
        $validated['shorten_url'] =ENV('APP_URL').'/'. base_convert($validated['original_url'],16,8);
        $url = new Url();
        $url->original_url = $validated['original_url'];
        $url->shorten_url = $validated['shorten_url'];
        $url->status = $validated['status'] ?? Status::Active;
        $url->save();
    }

    public function update($url, $validated) {

        $url->original_url = $validated['original_url'];
        $url->status = $validated['status'] ?? Status::Active;
    
            // Save the changes to the database
        $url->save();
    }
}
