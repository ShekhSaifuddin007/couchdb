<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CouchDBController extends Controller
{
    public const APPLICATION_JSON = 'application/json';
    public const JSON = 'json';

    public function index()
    {
        $responses = Http::get("{$this->url}/{$this->db}/_design/view3/_view/users?include_docs=true");
        // $responses = Http::get("{$this->url}/_all_dbs");
        // $responses = Http::get("{$this->url}/{$this->db}/_all_docs?include_docs=true");

        $users = collect($responses->json()['rows'])->map(function ($user) {
            // $address = "{$user['doc']['address']['street']}, {$user['doc']['address']['city']}, {$user['doc']['address']['district']}, {$user['doc']['address']['zip']}";

            return [
                'id' => $user['doc']['_id'],
                'rev' => $user['doc']['_rev'],
                'name' => $user['doc']['name'],
                'email' => $user['doc']['email'],
                'phone' => $user['doc']['phone'],
                'address' => $user['doc']['address'],
                'type' => $user['doc']['type']
            ];
        });

        // dd($users);

        return view('welcome', compact('users'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => [
                'street' => $request->address_street,
                'city' => $request->address_city,
                'district' => $request->address_district,
                'zip' => $request->address_zip,
            ],

            'type' => 'users'
        ];

        $uuid = Http::get($this->url . '_uuids')->json()['uuids'][0];

        $payload = json_encode($user);

        $response = Http::withBody($payload, self::APPLICATION_JSON)
            ->put($this->url . $this->db . '/' . $uuid);

        return back();
    }

    // public function edit($id)
    // {
    //     $response   = Http::get("{$this->url}{$this->db}/{$id}");

    //     return $response->json();
    // }

    public function update(Request $request)
    {
        $this->validateRequest($request);

        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => [
                'street' => $request->address_street,
                'city' => $request->address_city,
                'district' => $request->address_district,
                'zip' => $request->address_zip,
            ],

            'type' => 'users',
            '_rev' => $request->_rev
        ];

        $payload = json_encode($user);

        $response = Http::withBody($payload, self::APPLICATION_JSON)
            ->put($this->url.$this->db.'/'.$request->_id);

        return back();
    }

    public function destroy($id)
    {
        // dd($id, request('_rev'));

        $response = Http::delete($this->url.$this->db.'/'.$id.'?rev='.request('_rev'));

        return back();
    }

    public function validateRequest($request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:15'],
            'address_street' => ['nullable', 'string', 'max:100'],
            'address_city' => ['nullable', 'string', 'max:20'],
            'address_district' => ['nullable', 'string', 'max:30'],
            'address_zip' => ['nullable', 'string', 'max:10'],
        ]);
    }
}
