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
        $levels = Sensordata::orderBy('id', 'desc')
        ->pluck('level')
        ->first();

        if ($levels) {
            /*if ($level >= 0 && $level <= 50) {
                $this->level = 100 - $level * 2;
            } elseif ($level > 50) {
                $this->level = 0;
            } else {
                $this->level = 0; //Handle negative levels as 0.
            }*/

            $level = $levels;
        }
        else {
            $level = 0; // Handle null as 0.
        }

        return view('monitoring', ['level' => $level]);
    }

    public function report(){
        $levels = Sensordata::orderBy('id', 'desc')
        ->pluck('level')
        ->first();

        if ($levels) {
            /*if ($level >= 0 && $level <= 50) {
                $this->level = 100 - $level * 2;
            } elseif ($level > 50) {
                $this->level = 0;
            } else {
                $this->level = 0; //Handle negative levels as 0.
            }*/

            $level = $levels;
        }
        else {
            $level = 0; // Handle null as 0.
        }

        return view('report', ['level' => $level]);
    }

    public function dashboard(){
        $levels = Sensordata::orderBy('id', 'desc')
        ->pluck('level')
        ->first();

        if ($levels) {
            /*if ($level >= 0 && $level <= 50) {
                $this->level = 100 - $level * 2;
            } elseif ($level > 50) {
                $this->level = 0;
            } else {
                $this->level = 0; //Handle negative levels as 0.
            }*/

            $level = $levels;
        }
        else {
            $level = 0; // Handle null as 0.
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

    public function checkpin(Request $request)
    {
        $request->validate([
            'input_text' => 'required|string',
        ]);

        // Check if input matches "12345"
        $inputText = $request->input('input_text');
        
        if ($inputText === '12345') {
            return redirect()->route('dashboard')->with('success', 'The input is correct!');
        } else {
            return back()->with('error', 'The input is incorrect. Try again.');
        }
    }
}
