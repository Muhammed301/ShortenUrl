<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Actions\SaveUrlAction;
use App\DataObjectTransfer\UrlData;
use App\Enums\StatusType;
use App\Http\Requests\UrlResquest;

class HomeController extends Controller
{
    // Get all Url

    public function __construct( 
        public SaveUrlAction $saveUrl,
    ) {
    }
    public function index(){
        $urls = Url::all();

        $status = StatusType::toArray();

        return view('app.index', compact('urls' ,'status'));
    }

    // Save Url
    public function store(UrlResquest $request){
        
        $this->upSet($request, new Url());
        return redirect()->route('index')
        ->withSuccess('Operation Successful');

    }


    ///Edit Url view
    public function edit(Url $url){
        $status = StatusType::toArray();
        return view('app.edit', compact('url','status'));
    }


    /// Update URl
    public function update(UrlResquest $request ,Url $url)
    {
        $data = $this->upSet($request, $url);
        return redirect()->route('index')->withSuccess('Operation Successful');
    }

    public function upSet(UrlResquest $request, Url $url){
        $urlData = UrlData::FormRequest($request);
        $this->saveUrl->execute($urlData,$url);
    }
}
