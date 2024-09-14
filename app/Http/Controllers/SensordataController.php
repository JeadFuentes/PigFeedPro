<?php

namespace App\Http\Controllers;

use App\Models\Sensordata;
use App\Models\Feeding;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSensordataRequest;
use carbon\carbon;

class SensordataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = Feeding::all();
        $res = [
            'action' => 'feed'
        ];
        return response()->json($res);

       /* foreach ($results as $result){
            if ($result->time == carbon::now()->format('Y-m-d H:i:00'))
            {
                return response()->json($sensorData);
            }
        }*/
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'level' => 'required',
        ]);

        $post =  Sensordata::create($data);

        return response()->json(['success' => true, 'data' => $post], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sensordata $sensordata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSensordataRequest $request, Sensordata $sensordata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sensordata $sensordata)
    {
        //
    }
}
