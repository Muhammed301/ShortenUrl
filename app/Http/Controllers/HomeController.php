<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Enums\Status;
use App\Http\Controllers\Actions\CreateUrl;
use Illuminate\Http\Request;
use App\Http\Requests\UrlResquest;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    // Get all Url
    public function index(CreateUrl $get_urls){
        $urls = $get_urls->get_all();

        $status = Status::toSelectArray();

        return view('app.index', compact('urls' ,'status'));
    }

    // Save Url
    public function store(UrlResquest $request, CreateUrl $createUrl){
        $validated = $request->validated();
        try{
            
            $createUrl->save($validated);
                 

            return redirect()->route('index')
            ->withSuccess('Operation Successful');
        }catch(\Throwable $th) {
            return redirect()->route('index')
            ->with('something went wrong');
        }
    }


    ///Edit Url view
    public function edit(Url $url){
        $status = Status::toSelectArray();
        return view('app.edit', compact('url','status'));
    }


    /// Update URl
    public function update(UrlResquest $request, CreateUrl $createUrl,Url $url)
    {
        $validated = $request->validated();
    
        try {
            // Save the changes to the database
            $createUrl->update($url,$validated);
    
            return redirect()->route('index')->withInput()->withSuccess('Operation Successful');
        } catch (\Throwable $th) {
            Log::error($th);
    
            return redirect()->route('index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
