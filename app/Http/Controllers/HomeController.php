<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use App\Http\Requests\UrlResquest;

class HomeController extends Controller
{
    //
    public function index(){
        $urls = Url::all();

        return view('app.index', compact('urls'));
    }

    public function store(UrlResquest $request){
        $validated = $request->validated();
        try{
            $validated['shorten_url'] =ENV('APP_URL').'/'. base_convert($validated['original_url'],16,8);

            $Url = Url::create($validated)  ;      

            return redirect()->route('index')
            ->withSuccess('Operation Successful');
        }catch(\Throwable $th) {
            return redirect()->route('index')
            ->with('something went wrong');
        }
    }

    public function edit(Url $url){

        return view('app.edit', compact('url'));
    }

    public function update(UrlResquest $request, Url $url){
        $validated = $request->validated();

        try{
        $url->update($validated);
        return redirect()->route('index')
            ->withSuccess('Operation Successful');

        }catch(\Throwable $th) {
            return redirect()->route('index')
            ->with('something went wrong');
        }
    }
}
