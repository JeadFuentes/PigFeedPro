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

        foreach ($results as $result){
            if ($result->time == carbon::now()->format('Y-m-d H:i:00'))
            {
                return 'FEED NOW';
            }
        }
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

        return $post;
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
