<?php

use Livewire\Volt\Component;
use App\Models\Feeding;
use Carbon\Carbon;
use Livewire\WithPagination;

new class extends Component {
    use WithPagination;

    public $sortBy = 'id';
    public $sortDirection = 'asc';
    public $perPage = 5;
    public $search = 'pending';

    public $result = [];

    #[On('reload')]
    public function with(): array{
        return [
            //'feeds' => Feeding::orderBy('status','DESC')->get(),
            'feeds' => Feeding::search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage),
        ];
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
}; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col form-inline">
            <p class="d-inline px-3">Per Page:</p>
            <select wire:model="perPage" wire:change='with()' class="rounded d-inline px-3 w-8">
                <option>5</option>
                <option>10</option>
                <option>15</option>
                <option>20</option>
                <option>25</option>
            </select>
        </div>
        <div class="col">
            <input wire:model.debounce.300ms="search" class="form-control" type="text" placeholder="search">
        </div>
    </div>
    <table class="table text-center">
        <thead>
          <tr>
            <th style="cursor: pointer" wire:click="sortingBy('id')" scope="col">ID &ensp; @include('partials.sort-icon',['field'=>'id'])</th>
            <th style="cursor: pointer" wire:click="sortingBy('desc')" class="text-center">DESC &ensp; @include('partials.sort-icon',['field'=>'desc'])</th>
            <th style="cursor: pointer" wire:click="sortingBy('unit')" class="text-center">UNIT/kg &ensp; @include('partials.sort-icon',['field'=>'unit'])</th>
            <th style="cursor: pointer" wire:click="sortingBy('time')" class="text-center">FEED TIME &ensp; @include('partials.sort-icon',['field'=>'time'])</th>
            <th style="cursor: pointer" wire:click="sortingBy('status')" class="text-center">STATUS &ensp; @include('partials.sort-icon',['field'=>'status'])</th>
            <th class="text-center">ACTION</th>
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
                  <td>
                    @if ($res['status'] == 'pending')
                      <button wire:click="openEdit({{$res['id']}})" type="button" class="btn btn-sm btn-success">Edit</button>
                    @endif
                    <button wire:click="openDelete({{$res['id']}})" type="button" class="btn btn-sm btn-danger">Delete</button>
                  </td>
                </tr>
              @endforeach
        </tbody>
    </table>
    {{$feeds->links()}}
</div>
