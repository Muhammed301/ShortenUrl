<?php
namespace App\Actions;

class ShortenUrlHelper
{
    public function execute($url){
        $shorten_url = config('app.url') .'/'. base_convert($url,16,8);
        return $shorten_url;
    }
}