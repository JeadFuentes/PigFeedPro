<?php

use Livewire\Volt\Component;
use App\Models\Feeding;
use Carbon\Carbon;

new class extends Component {
    public $result = [];

    public $startDate;
    public $endDate;

    public function mount(){
        $feeds = Feeding::orderBy('status','DESC')->get();

        foreach ($feeds as $feed) {
                $this->result [] =[
                'id' => $feed->id,
                'desc' => $feed->desc,
                'unit' => $feed->unit,
                'time' => $feed->time,
                'status' => $feed->status,
            ];
        }
    }

    public function preview(){
      $this->result = [];

      $feeds = Feeding::whereBetween('time',[$this->startDate,$this->endDate])->get();

        foreach ($feeds as $feed) {
                $this->result [] =[
                'id' => $feed->id,
                'desc' => $feed->desc,
                'unit' => $feed->unit,
                'time' => $feed->time,
                'status' => $feed->status,
            ];
        }
    }

    public function print(){
      $feeds = Feeding::whereBetween('time',[$this->startDate,$this->endDate])->get();
  
        $pdfdata = [
            'data' => $feeds,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
          ];

        $pdf = Pdf::loadView('print', ['pdfdata' => $pdfdata])->setPaper('a4', 'landscape');
        return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
        }, 'Feeding Report.pdf');
    }
}; ?>

<div class="container-sm">
    <div class="w-25">
        <label for="startDate" class="text" style="font-size: 15px; padding-left:0">Start Date</label>
        <input wire:model="startDate" id="startDate" name="startDate" class="form-control" type="datetime-local" step="1" />
        
        <label for="endDate" class="text" style="font-size: 15px; padding-left:0">End Date</label>
        <input wire:model="endDate" id="endDate" name="endDate" class="form-control" type="datetime-local" step="1"/>
        
        <button wire:click="preview()" type="button" class="btn btn-md btn-primary ml-3 mb-3 mt-4">Preview</button>
        <button wire:click="print()" type="button" class="btn btn-md btn-success ml-3 mb-3 mt-4">Print Report</button>
    </div>

    <table class="table text-center">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th class="text-center">DESC</th>
            <th class="text-center">UNIT/kg</th>
            <th class="text-center">FEED TIME</th>
            <th class="text-center">STATUS</th>
          </tr>
        </thead>
        <tbody table-group-divider>
            @foreach ($this->result as $res)
            <tr>
              <td>{{$res['id']}}</td>
              <td>{{$res['desc']}}</td>
              <td>{{$res['unit']}}</td>
              <td>{{$res['time']}}</td>
              <td>{{$res['status']}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
</div>
@script
  <script>
      let x = document.getElementById("startDate");
      let y = document.getElementById("endDate");
      x.addEventListener("change", start);
      y.addEventListener("change", end);

    function start() {
      var val = x.value;
      val = val.replace("T", " ");
      @this.startDate = val;
    }

    function end() {
      var val = y.value;
      val = val.replace("T", " ");
      @this.endDate = val;
    }
  </script>
@endscript