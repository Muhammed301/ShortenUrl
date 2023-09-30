<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Enums\Status;
use App\Actions\SaveUrl;
use Illuminate\Http\Request;
use App\Http\Requests\UrlResquest;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    // Get all Url
    protected $saveUrl;

    public function __construct(SaveUrl $saveUrl) {
        $this->saveUrl = $saveUrl;
    }
    public function index(){
        $urls = Url::all();

        $status = Status::toSelectArray();

        return view('app.index', compact('urls' ,'status'));
    }

    // Save Url
    public function store(UrlResquest $request){
        $validated = $request->validated();
        try{
            // $createUrl = new CreateUrl;
            $this->saveUrl->execute($validated,new Url());
                 

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
    public function update(UrlResquest $request ,Url $url)
    {
        $validated = $request->validated();
    
        try {
            // Save the changes to the database
            $this->saveUrl->execute($validated,$url);
    
            return redirect()->route('index')->withInput()->withSuccess('Operation Successful');
        } catch (\Throwable $th) {
            Log::error($th);
    
            return redirect()->route('index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
