<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ComplaintController extends Controller
{
    //
    public function index()
    { 
        if (Cookie::get('api_token')) {
        $client = new Client();
        $response = $client->get(env('API_URL') . '/complaint/all');
        // $response = $client->get('http://localhost:3000/complaint/all');
        $res = json_decode($response->getBody())->data ; 
        $log = $this->paginate($res);
        // dd($log);
        return view('backend.complaintlog.complaintlog')->with('log',$log);
         
        }
        
        return view('backend.register.signup');
    }

    public function paginate($items, $perPage = 10, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);

    }
    
}