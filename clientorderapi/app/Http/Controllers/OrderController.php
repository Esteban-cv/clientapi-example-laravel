<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{

    private $cities = [
        ['name' => 'TULUA', 'value' => 'TULUA'],
        ['name' => 'CALI', 'value' => 'CALI'],
        ['name' => 'BUGA', 'value' => 'BUGA'],
        ['name' => 'PALMIRA', 'value' => 'PALMIRA']
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken($token = Session::get('token'))->get($url . '/order');
        if ($response->successful()) {
            $orders = $response->json();
            return view('order.index', compact('orders'));
        } else {
            abort($response->status());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $responseCausals = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/causal');
        $responseObservations = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/observation');
        if ($responseCausals->successful() and $responseObservations->successful()) {
            $causals = $responseCausals->json();
            $observations = $responseObservations->json();
            $cities = $this->cities;
            return view('order.create', compact('causals', 'observations', 'cities'));
        } else {
            abort($responseCausals->status());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->post($url . '/order', [
            'legalization_date' => $request->legalization_date,
            'address' => $request->address,
            'city' => $request->city,
            'causal_id' => $request->causal_id,
            'observation_id' => $request->observation_id
        ]);
        if ($response->successful()) {
            session()->flash('message', 'La orden se creo correctamente');
            return redirect()->route('order.index');
        } elseif ($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('order.create')->withInput()->withErrors($errors);
        } else {
            abort($response->status());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/order/' . $id);
        if ($response->successful()) {
            $responseCausals = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/causal');
            $responseObservations = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/observation');
            if ($responseCausals->successful() and $responseObservations->successful()) {

                $causals = $responseCausals->json();
                $observations = $responseObservations->json();
                $order = $response->json();
                $cities = $this->cities;
                return view('order.edit', compact('order', 'causals', 'observations', 'cities'));
            } else {
                abort($responseCausals->status());
            }
        } elseif ($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('order.index')->withInput()->withErrors($errors);
        } else {
            abort($response->status());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->put($url . '/order/' . $id, [
            'id' => $request->id,
            'legalization_date' => $request->legalization_date,
            'address' => $request->address,
            'city' => $request->city,
            'causal_id' => $request->causal_id,
            'observation_id' => $request->observation_id
        ]);
        if ($response->successful()) {
            session()->flash('message', 'La orden se actualizó correctamente');
            return redirect()->route('order.index');
        } elseif ($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('order.edit')->withInput()->withErrors($errors);
        } else {
            abort($response->status());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $response = Http::acceptJson()->withToken(Session::get('token'))->delete($url . '/order/' . $id);
        if ($response->successful()) {
            session()->flash('message', 'La orden se eliminó correctamente');
            return redirect()->route('order.index');
        } elseif ($response->status() == Response::HTTP_BAD_REQUEST) {
            $errors = $response->json()['errors'];
            return redirect()->route('order.index')->withInput()->withErrors($errors);
        } else {
            abort($response->status());
        }
    }


    /**
     * añade una actividad a la orden
     */
    public function add_activity(String $order_id, String $activity_id) {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $responseOrder = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/order/' . $order_id);
        $responseActivity = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/activity/' . $activity_id);
        if($responseOrder->successful() and $responseActivity->successful()) {
            //guardar actividad en order_activity
            $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/order/add_activity/' . $order_id. '/' . $activity_id);
            if($response->successful()) {
                session()->flash('message', 'Actividad agregada exitosamente');
                return redirect()->route('order.edit', $order_id);
            }
            else {
                session()->flash('error', 'Error agregando la actividad');
            }
            return redirect()->route('order.edit', $order_id);
        }
        else {
            abort($responseOrder->status());
        }
    }


    /**
     * Retira una acitvidad a la orden
     */
    public function remove_activity(String $order_id, String $activity_id) {
        $url = env('URL_BASE_API', "http://localhost:8000");
        $responseOrder = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/order/' . $order_id);
        $responseActivity = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/activity/' . $activity_id);
        if($responseOrder->successful() and $responseActivity->successful()) {
            //guardar actividad en order_activity
            $response = Http::acceptJson()->withToken(Session::get('token'))->get($url . '/order/remove_activity/' . $order_id. '/' . $activity_id);
            if($response->successful()) {
                session()->flash('message', 'Actividad removida exitosamente');
                return redirect()->route('order.edit', $order_id);
            }
            else {
                session()->flash('error', 'Error removiendo la actividad');
            }
            return redirect()->route('order.edit', $order_id);
        }
        else {
            abort($responseOrder->status());
        }
    }
}

