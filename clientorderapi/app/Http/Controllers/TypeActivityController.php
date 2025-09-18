<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class TypeActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken($token = Session::get('token'))->get($url . '/type_activity');
        if ($response->successful()) {
            $typeActivities = $response->json();
            return view('typeactivity.index', compact('typeActivities'));
        } else {
            abort($response->status());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('typeactivity.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->post($url . '/type_activity', [
            'description' => $request->description
        ]);
        if ($response->successful()) {
            session()->flash('message', 'El tipo de actividad se creo correctamente');
            return redirect()->route('typeactivity.index');
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('typeactivity.create')->withInput()->withErrors($errors);
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
        $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/type_activity/'. $id);
        if ($response->successful()) {
            $typeActivity = $response->json();
            return view('typeactivity.edit', compact('typeActivity'));
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('typeactivity.index')->withInput()->withErrors($errors);
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
        $response = Http::acceptJson()->withToken(Session::get('token'))->put($url . '/type_activity/'. $id, [
            'id' => $request->id,
            'description' => $request->description
        ]);
        if ($response->successful()) {
            session()->flash('message', 'El tipo de actividad se actualizo correctamente');
            return redirect()->route('typeactivity.index');
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('typeactivity.edit')->withInput()->withErrors($errors);
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
        $response = Http::acceptJson()->withToken(Session::get('token'))->delete($url . '/type_activity/'. $id);
        if ($response->successful()) {
            session()->flash('message', 'El tipo de actividad se eliminó correctamente');
            return redirect()->route('typeactivity.index');
        }
        elseif($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('typeactivity.index')->withInput()->withErrors($errors);
        }
        else {
            abort($response->status());
        }
    }
}
