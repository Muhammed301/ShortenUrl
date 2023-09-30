<?php

namespace App\Actions;

use App\Models\Url;
use App\Actions\ShortenUrlHelper;
use App\DataObjectTransfer\UrlData;
use App\Enums\StatusType;

class SaveUrlAction 
{
    public function __construct( public ShortenUrlHelper $shortenUrl) {
    }
    
    public function execute(UrlData $urlData,Url $url): Url{

            $url->original_url = $urlData->url;
            $shorten_url = $url->shorten_url ?? $this->shortenUrl->execute($urlData->url);
             $url->shorten_url = $shorten_url;
            $url->status = $urlData->status;  
    
            $url->save();
            return  $url;
    
        
    }
}
