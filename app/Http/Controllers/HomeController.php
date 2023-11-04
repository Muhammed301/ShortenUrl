<?php

namespace App\Http\Controllers;

use App\Models\Url;
use App\Enums\StatusType;
use App\Actions\SaveUrlAction;
use App\Actions\SaveUserAction;
use App\Http\Requests\UrlResquest;
use App\DataObjectTransfer\UrlData;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // Get all Url

    public function __construct( 
        public SaveUrlAction $saveUrl,
        public SaveUserAction  $saveUserAction
    ) {
    }
    public function index(){
        $urls = Url::all();

        $status = StatusType::toArray();

        return view('app.index', compact('urls' ,'status'));
    }

    // Save Url
    public function store(UrlResquest $request){
        $user = Auth::user();
        $data= [];
        if($user->url_count <= 5){
            $data['url_count']=$user->url_count + 1 ;
        }elseif($user->wallet_balance >= 100){
            $data['url_count']=$user->url_count + 1 ;
            $data['wallet_balance']=$user->wallet_balance - 100 ;
        }else{
            return back()->withError('Kindly Fund Your Wallet');
        }
        $this->upSet($request, new Url());
        
        $this->saveUserAction->execute($user,$data);
        
        return redirect()->route('index')
        ->withSuccess('Operation Successful');
        //test

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

       $user= Auth::user();
        $this->saveUrl->execute($urlData,$url);
    }
}
