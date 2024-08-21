<?php

use Livewire\Volt\Component;

new class extends Component {
    public $result = [];
}; ?>

<div class="container-sm">
    <button wire:click="addNew()" type="button" class="btn btn-md btn-primary ml-3 mb-3">ADD NEW SCHEDULE</button>
    <button wire:click="feedNow()" type="button" class="btn btn-md btn-success ml-3 mb-3">FEED NOW</button>
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
              <td>{{$res['name']}}</td>
              <td>{{$res['unit']}}</td>
              <td>{{$res['date-created']}}</td>
              <td>
                <button wire:click="openEdit({{$res['id']}})" type="button" class="btn btn-sm btn-success">Edit</button>
                <button wire:click="openDelete({{$res['id']}})" type="button" class="btn btn-sm btn-danger">Delete</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>

      <!-- Add New -->
  <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h1 class="modal-title fs-5" id="newModalLabel">ADD NEW DEPARTMENT</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form wire:submit="newDepartment" class="space-y-6">
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full text-uppercase" required autofocus autocomplete="name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
        
                <div>
                    <x-input-label for="unit" :value="__('Unit')" />
                    <x-text-input wire:model="unit" id="unit" name="unit" type="text" class="mt-1 block w-full text-uppercase" required autocomplete="unit" />
                    <x-input-error class="mt-2" :messages="$errors->get('unit')" />
                </div>
        
                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
        
                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>