<?php

use Livewire\Volt\Component;
use App\Models\Feeding;
use Carbon\Carbon;
use Livewire\WithPagination;

new class extends Component {
  use WithPagination;
    public $result = [];

    public $startDate;
    public $endDate;

    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $perPage = 10;
    public $search = '';

    public $rpt = 0;

    #[On('reload')]
    public function with(): array{
      
      if ($this->rpt == 1) {
        $this->rpt = 0;
        return [
            //'feeds' => Feeding::orderBy('status','DESC')->get(),
            'feeds' => Feeding::search($this->search)
            ->whereBetween('time',[$this->startDate,$this->endDate])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage),
        ];
      }
      else{
        $this->startDate = '';
        $this->endDate = '';
        return [
            //'feeds' => Feeding::orderBy('status','DESC')->get(),
            'feeds' => Feeding::search($this->search)
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage),
        ];
      }
        
    }

    public function sortingBy($field){
        if ($this->sortDirection == 'asc'){
            $this->sortDirection = 'desc';
        }
        else{
            $this->sortDirection = 'asc';
        }

        $this->dispatch('reload');
        return $this->sortBy = $field;
    }

    public function updatingSearch(){
      $this->resetPage();
    }

    public function preview(){
      $this->result = [];
      $this->rpt = 1;
      $feeds = Feeding::search($this->search)
            ->orwhereBetween('time',[$this->startDate,$this->endDate])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();

        foreach ($feeds as $feed) {
                $this->result [] =[
                'id' => $feed->id,
                'desc' => $feed->desc,
                'unit' => $feed->unit,
                'time' => $feed->time,
                'status' => $feed->status,
            ];
        }
        
        $this->dispatch('reload');
    }

    public function print(){
      if($this->rpt === 1){
        $total = array_sum(array_column($this->result, 'unit'));

        $pdfdata = [
            'data' => $this->result,
            'total' => $total,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
          ];
          $this->startDate = '';
          $this->endDate = '';

        $pdf = Pdf::loadView('print', ['pdfdata' => $pdfdata])->setPaper('a4', 'landscape');
        return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
        }, 'Feeding Report.pdf');
      }
      else{
        $feeds = Feeding::whereBetween('time',[$this->startDate,$this->endDate])->get();
        $total =  $feeds->sum('unit');

        $pdfdata = [
            'data' => $feeds,
            'total' => $total,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
          ];
          $this->startDate = '';
          $this->endDate = '';

        $pdf = Pdf::loadView('print', ['pdfdata' => $pdfdata])->setPaper('a4', 'landscape');
        return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
        }, 'Feeding Report.pdf');
      }
    }
}; ?>

<div class="container-sm mb-5">
  <div class="p-2 w-100">
    <input id="searchTxt" class="form-control w-100" type="text" step="1" placeholder="Search">
  </div>
    <div class="w-100">
      <div class="d-sm-inline-flex flex-row">
        <div class="p-2">
          <label for="startDate" class="text" style="font-size: 15px; padding-left:0">Start Date</label>
          <input wire:model="startDate" id="startDate" name="startDate" class="form-control" type="datetime-local" step="1" />
        </div>
        <div class="p-2">
          <label for="endDate" class="text" style="font-size: 15px; padding-left:0">End Date</label>
          <input wire:model="endDate" id="endDate" name="endDate" class="form-control" type="datetime-local" step="1"/>
        </div>
      </div>       
    </div>
    <div class="d-flex flex-row mb-3">
      <div class="p-2">
        <button wire:click="preview()" type="button" class="btn btn-md btn-primary ml-3 mb-3 mt-4">Preview</button>
      </div>
      <div class="p-2">
        <button wire:click="print()" type="button" class="btn btn-md btn-success ml-3 mb-3 mt-4">Print</button>
      </div>
    </div>

    <div class="form-inline">
      <p class="d-inline px-3">Per Page:</p>
      <select wire:model="perPage" wire:change='with()' class="rounded d-inline px-3 w-8">
          <option>5</option>
          <option>10</option>
          <option>15</option>
          <option>20</option>
          <option>25</option>
      </select>
  </div>
    <table class="table text-center table-responsive-sm">
        <thead>
          <tr>
            <th style="cursor: pointer" wire:click="sortingBy('id')" scope="col">ID &ensp; @include('partials.sort-icon',['field'=>'id'])</th>
            <th style="cursor: pointer" wire:click="sortingBy('desc')" class="text-center">DESC &ensp; @include('partials.sort-icon',['field'=>'desc'])</th>
            <th style="cursor: pointer" wire:click="sortingBy('unit')" class="text-center">UNIT/kg &ensp; @include('partials.sort-icon',['field'=>'unit'])</th>
            <th style="cursor: pointer" wire:click="sortingBy('time')" class="text-center">FEED TIME &ensp; @include('partials.sort-icon',['field'=>'time'])</th>
            <th style="cursor: pointer" wire:click="sortingBy('status')" class="text-center">STATUS &ensp; @include('partials.sort-icon',['field'=>'status'])</th>
          </tr>
        </thead>
        <tbody table-group-divider>
            @foreach ($feeds as $res)
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
      {{$feeds->links()}}
    <br>
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

    $(document).ready(function(){
      $('#searchTxt').on('keyup',function(){
        @this.search = $(this).val();
        @this.call('with');
      })
    });
  </script>
@endscript