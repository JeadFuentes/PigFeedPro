<?php

use Livewire\Volt\Component;

new class extends Component {
    public $result = [];
}; ?>

<div class="container-sm">
    <div class="w-25">
        <label for="startDate">Start</label>
        <input id="startDate" class="form-control" type="datetime-local" />
        <label for="endDate">End</label>
        <input id="endDate" class="form-control" type="datetime-local" />
        <button wire:click="addNew()" type="button" class="btn btn-md btn-primary ml-3 mb-3 mt-4">View Report</button>
        <button wire:click="feedNow()" type="button" class="btn btn-md btn-success ml-3 mb-3 mt-4">Print Report</button>
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
              <td>{{$res['name']}}</td>
              <td>{{$res['unit']}}</td>
              <td>{{$res['date-created']}}</td>
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
                    <label for="name" :value="__('Name')" ></label>>
                    <input type="text" wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full text-uppercase" required autofocus autocomplete="name" />
                    @error('unit')
                        <p class="text-danger">This field is needed</p>
                    @enderror
                </div>
        
                <div>
                    <label for="unit" :value="__('Unit')" ></label>>
                    <input type="text" wire:model="unit" id="unit" name="unit" type="text" class="mt-1 block w-full text-uppercase" required autocomplete="unit" />
                      @error('unit')
                        <p class="text-danger">This field is needed</p>
                     @enderror
                </div>
        
                <div class="mt-6 flex justify-end">
                    <button name="cancel">{{ __('Cancel') }}</button>
        
                    <div class="flex items-center gap-4">
                      <button type="submit" name="submit">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
