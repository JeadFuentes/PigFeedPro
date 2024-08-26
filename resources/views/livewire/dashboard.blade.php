<?php

use Livewire\Volt\Component;
use App\Models\Feeding;

new class extends Component {
    public $result = [];
    public string $desc;
    public string $unit;
    public string $feed;

    public function mount(){
        $feeds = Feeding::all();

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

    public function addNew(){
      $this->dispatch('openAddNewModal');
    }
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
            <th class="text-center">ACTION</th>
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
                    <label for="desc" class="form-label" >DESCRIPTION</label>
                    <input type="text" wire:model="desc" id="desc" name="desc" type="text" class="mt-1 block w-full form-control" required autofocus autocomplete="desc" />
                    @error('desc')
                        <p class="text-danger">This field is needed</p>
                    @enderror
                </div>
        
                <div>
                    <label for="unit" class="form-label">UNIT</label>
                    <input type="text" wire:model="unit" id="unit" name="unit" type="text" class="mt-1 block w-full form-control" required autocomplete="unit" />
                      @error('unit')
                        <p class="text-danger">This field is needed</p>
                     @enderror
                </div>

                <div>
                  <label for="feed" class="form-label">FEED TIME</label>
                  <input wire:model="feed" id="feed" name="feed" type="datetime-local" class="mt-1 block w-full form-control" />
                    @error('feed')
                      <p class="text-danger">This field is needed</p>
                   @enderror
                </div>

                <div class="mt-5 row">
                  <div class="col">
                    <button class="btn btn-danger" name="cancel">{{ __('Cancel') }}</button>
                      <button class="btn btn-success" type="submit" name="submit">{{ __('Save') }}</button>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@script
 <script>
    $wire.on('openAddNewModal', () => {
      $('#addNewModal').modal('show');
    });
    $wire.on('showEditModal', () => {
      $('#editModal').modal('show');
    });
    $wire.on('showDeleteModal', () => {
      $('#deleteModal').modal('show');
    });
    $wire.on('close', () => {
      $('#deleteModal').modal('hide');
      $('#editModal').modal('hide');
      $('#addNewModal').modal('hide');
    });

 </script>
@endscript