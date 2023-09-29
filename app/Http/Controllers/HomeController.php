<?php

namespace App\Http\Controllers;

use App\Enums\Status;
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

            $url = new Url();
            $url->original_url = $validated['original_url'];
            $url->shorten_url = $validated['shorten_url'];
            $url->status = Status::Active;
            $url->save();     

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
            $url = new Url();
            $url->original_url = $validated['original_url'];
            $url->shorten_url = $validated['shorten_url'];
            $url->update();     

        return redirect()->route('index')
            ->withSuccess('Operation Successful');

        }catch(\Throwable $th) {
            return redirect()->route('index')
            ->with('something went wrong');
        }
    }
}
