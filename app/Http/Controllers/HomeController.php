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
    protected $createUrl;

    public function __construct(CreateUrl $createUrl) {
        $this->createUrl = $createUrl;
    }
    public function index(){
        $urls = $this->createUrl->get_all();

        $status = Status::toSelectArray();

        return view('app.index', compact('urls' ,'status'));
    }

    // Save Url
    public function store(UrlResquest $request){
        $validated = $request->validated();
        try{
            // $createUrl = new CreateUrl;
            $this->createUrl->save($validated);
                 

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
            $this->createUrl->update($url,$validated);
    
            return redirect()->route('index')->withInput()->withSuccess('Operation Successful');
        } catch (\Throwable $th) {
            Log::error($th);
    
            return redirect()->route('index')->with('error', 'Something went wrong. Please try again.');
        }
    }
}
