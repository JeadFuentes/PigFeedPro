<?php

namespace App\Http\Controllers;

use App\Models\Sensordata;
use App\Models\Feeding;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSensordataRequest;
use Illuminate\Support\Str;
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
            if ($result['time'] == carbon::now()->format('Y-m-d H:i:00'))
            {
                $res = [
                    'action' => 'feed'
                ];
                //add function to edit the status
                $feeding = Feeding::find($result['id']);

                $validated = [
                    'status' => 'done',
                ];

                $feeding->fill($validated);

                $feeding->save();

                return response()->json($res);
            }
        }

        $nextTime = Feeding::where('status', 'pending')
                   ->orderBy('time', 'desc')
                   ->pluck('time')
                   ->first();
                return ($nextTime);
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

    public function monitoring(){
        $level = Sensordata::orderBy('id', 'desc')
        ->pluck('level')
        ->first();

         // 60 is empty 0 is full

         if ($level > 0) {
            $level = 100 - $level + 10;
             $level = $level;
         }
         else{
             $level = 0;
         }

        return view('monitoring', ['level' => $level]);
    }

    public function report(){
        $level = Sensordata::orderBy('id', 'desc')
        ->pluck('level')
        ->first();

         // 60 is empty 0 is full

         if ($level > 0) {
            $level = 100 - $level + 10;
             $level = $level;
         }
         else{
             $level = 0;
         }

        return view('report', ['level' => $level]);
    }

    public function dashboard(){
        $level = Sensordata::orderBy('id', 'desc')
        ->pluck('level')
        ->first();

         // 60 is empty 0 is full
         

         if ($level > 0) {
            $level = 100 - $level + 10;
             $level = $level;
         }
         else{
             $level = 0;
         }

        return view('welcome', ['level' => $level]);
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
