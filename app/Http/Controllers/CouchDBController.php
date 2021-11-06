<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CouchDBController extends Controller
{
    public function index()
    {
        $responses = Http::dd()->get('http://admin:shekh@localhost:5984/test_database/_design/view3/_view/users?include_docs=true');

        // dd($responses);

        return view('welcome');
    }
}
