<?php

namespace App\Actions;

use App\Models\Url;
use App\Enums\Status;
use App\Actions\ShortenUrlHelper;
use Illuminate\Support\Facades\Log;

class SaveUrl 
{
    protected $shortenUrl;
    public function __construct(ShortenUrlHelper $shortenUrl) {
        $this->shortenUrl = $shortenUrl;
    }
    
    public function execute($validated, $url){

        try{
            $validated['shorten_url'] =$url->shorten_url ?? $this->shortenUrl->execute($validated['original_url']);
            $url->original_url = $validated['original_url'];
            $url->shorten_url = $validated['shorten_url'];
            $url->status = $validated['status'] ?? Status::Active;  
    
            $url->save();
            return $url;
        }catch (\Exception $e) {
            Log::error('Error occurred: ' . $e->getMessage());
    
        }
        
    }
}
