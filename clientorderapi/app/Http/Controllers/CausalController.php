<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use LDAP\Result;

class CausalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken($token = Session::get('token'))->get($url . '/causal');
        if ($response->successful()) {
            $causals = $response->json();
            return view('causal.index', compact('causals'));
        } else {
            abort($response->status());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('causal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->post($url . '/causal', [
            'description' => $request->description
        ]);
        if ($response->successful()) {
            session()->flash('message', 'El registro se creo correctamente');
            return redirect()->route('causal.index');
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('causal.create')->withInput()->withErrors($errors);
        }
        else {
            abort($response->status());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/causal/'. $id);
        if ($response->successful()) {
            $causal = $response->json();
            return view('causal.edit', compact('causal'));
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('causal.index')->withInput()->withErrors($errors);
        }
        else {
            abort($response->status());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->put($url . '/causal/'. $id, [
            'id' => $request->id,
            'description' => $request->description
        ]);
        if ($response->successful()) {
            session()->flash('message', 'El registro se actualizo correctamente');
            return redirect()->route('causal.index');
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('causal.edit')->withInput()->withErrors($errors);
        }
        else {
            abort($response->status());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->delete($url . '/causal/'. $id);
        if ($response->successful()) {
            session()->flash('message', 'El registro se eliminó correctamente');
            return redirect()->route('causal.index');
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('causal.index')->withInput()->withErrors($errors);
        }
        else {
            abort($response->status());
        }
    }
}
