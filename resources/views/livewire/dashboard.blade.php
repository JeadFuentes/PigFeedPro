<?php

use Livewire\Volt\Component;
use App\Models\Feeding;
use Carbon\Carbon;
use Livewire\WithPagination;

new class extends Component {
  use WithPagination;

    public $result = [];
    public $feedId;
    public string $desc;
    public float $unit =.5;
    public string $feed;
    public $time;
    public string $status;

    public $sortBy = 'id';
    public $sortDirection = 'desc';
    public $perPage = 10;
    public $search = '';

    public $processing = false;

    #[On('reload')]
    public function with(): array{
        return [
            'feeds' => Feeding::search($this->search)->orderBy($this->sortBy, $this->sortDirection)->paginate($this->perPage),
        ];
    }

      //feedNow
    public function openFeedNow(){
      $this->dispatch('openFeedNowModal');
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

    //addnew
    public function addNew(){
      $this->dispatch('openAddNewModal');
    }

    public function newDepartment(){
        $validated = $this->validate([
            'desc' => ['required', 'string', 'max:255'],
            'unit' => ['required'],
            'feed' => ['required'], 
        ]);

        Feeding::create([
          'desc' => $validated['desc'],
          'unit' => $validated['unit'],
          'time' => $validated['feed'],
          'status' => 'pending',
        ]);

        session()->flash('message', 'Added Succesfully');
        $this->redirect(route('dashboard'));
    }

    public function feedNow(){
      $newDateTime = Carbon::now()->format('Y-m-d H:i:00');

        Feeding::create([
          'desc' => 'Feed Now',
          'unit' => '.5',
          'time' => $newDateTime,
          'status' => 'done',
        ]);

        session()->flash('message', 'Feeded Succesfully');
        $this->dispatch('opendelay');
        //sleep(5);
        //$this->redirect(route('dashboard'));
        //$this->processAction();
        //$this->dispatch('close');
    }

    //edit
    public function openEdit($id){
        $feeding = Feeding::find($id);

        $this->feedId = $feeding->id;
        $this->desc = $feeding->desc;
        $this->unit = $feeding->unit;
        $this->feedEdit = $feeding->time;
        $this->status = $feeding->status;
        $this->dispatch('showEditModal');
    }

    public function editFeeding(){
        $feeding = Feeding::find($this->feedId);

        $validated = $this->validate([
            'feedId' => ['required', 'max:255'],
            'desc' => ['required', 'string', 'max:255'],
            'time' => ['required'], 
            'status' => ['required', 'max:255'],
        ]);

        $feeding->fill($validated);
        $feeding->save();

        session()->flash('message', 'Edited Succesfully');
        $this->redirect(route('dashboard'));
    }

    //delete
    public function openDelete($id){
        $this->feedId = $id;

        $this->dispatch('showDeleteModal');
    }

    public function deleteFeeding()
    {
        $feeding = Feeding::find($this->feedId);

        $feeding->delete();
        session()->flash('message', 'Deleted Succesfully');
        $this->redirect(route('dashboard'));
    }
}; ?>

<div class="container-sm">
  <div class="container">
      <input id="searchTxt" class="form-control mb-3" type="text" placeholder="search">
    <div class="row">
      <div class="col">
        <button wire:click="addNew()" type="button" class="btn btn-md btn-primary ml-3 mb-3">ADD NEW SCHEDULE</button>
        <button wire:click="openFeedNow()" type="button" class="btn btn-md btn-success ml-3 mb-3">FEED NOW</button>
      </div>
    </div>
  </div>
  <div class="row mt-2 mb-2">
    <div class="col">
        <p class="d-inline px-3 text" style="font-size: 15px;">Per Page:</p>
        <select wire:model="perPage" wire:change='with()' class="rounded d-inline px-3 w-8">
            <option>5</option>
            <option>10</option>
            <option>15</option>
            <option>20</option>
            <option>25</option>
        </select>
    </div>
  </div>
    <table class="table text-center table-responsive-sm">
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

      <!-- Add New -->
  <div class="modal fade" id="addNewModal" tabindex="-1" aria-labelledby="newModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h1 class="modal-title fs-5" id="newModalLabel">ADD NEW SCHEDULE</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form wire:submit="newDepartment" class="space-y-6">
                <div>
                    <label for="desc" class="form-label" >DESCRIPTION</label>
                    <input type="text" wire:model="desc" id="desc" name="desc" class="mt-1 block w-full form-control" required autofocus autocomplete="desc" />
                    @error('desc')
                        <p class="text-danger">This field is needed</p>
                    @enderror
                </div>
        
                <div>
                    <label for="unit" class="form-label">UNIT/KG</label>
                    <input type="float" wire:model="unit" id="unit" name="unit" class="mt-1 block w-full form-control" value=".5" placeholder="0.5" autocomplete="unit" />
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
                      <button class="btn btn-success" type="submit" name="submit">{{ __('Save') }}</button>
                  </div>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
  <!--edit-->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h1 class="modal-title fs-5" id="editModalLabel">EDIT FEEDING SCHEDULE</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form wire:submit="editFeeding" class="space-y-6">
              <div>
                <input type="text" wire:model="feedId" id="feedId" name="feedId" class="mt-1 block w-full form-control" required disabled />
              </div>

              <div>
                <label for="desc" class="form-label" >DESCRIPTION</label>
                <input type="text" wire:model="desc" id="desc" name="desc" class="mt-1 block w-full form-control" required autofocus autocomplete="desc" />
                @error('desc')
                    <p class="text-danger">This field is needed</p>
                @enderror
              </div>
    
            <div>
                <label for="unit" class="form-label">UNIT/KG</label>
                <input type="text" wire:model="unit" id="unit" name="unit" class="mt-1 block w-full form-control" required autocomplete="unit" disabled/>
                  @error('unit')
                    <p class="text-danger">This field is needed</p>
                 @enderror
            </div>

            <div>
              <label for="time" class="form-label">FEED TIME</label>
              <input wire:model="time" id="time" name="time" type="datetime-local" class="mt-1 block w-full form-control" />
                @error('feed')
                  <p class="text-danger">This field is needed</p>
               @enderror
            </div>

            <div class="pt-4">
              <input type="text" wire:model="status" id="status" name="status" class="mt-1 block w-full form-control" required disabled />
            </div>

            <div class="mt-5 row">
              <div class="col">
                  <button class="btn btn-success" type="submit" name="submit">{{ __('Save') }}</button>
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
    <!-- Delete -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <h1 class="modal-title fs-5" id="deleteModalLabel">DELETE SCHEDULE</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form wire:submit="deleteFeeding">
  
                  <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                      {{ __('Are you sure you want to delete the Feeding Schedule?')}}
                  </h2>
          
                  <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                      {{ __('Once the Feeding Schedule is deleted, all of its resources and data will be permanently deleted.') }}
                  </p>
          
                  <div class="mt-6 flex justify-end">
                      <button class="ms-3 btn btn-danger">
                          {{ __('Delete Schedule') }}
                      </button>
                  </div>
              </form>
          </div>
        </div>
      </div>
    </div>
    <!-- FeedNow Confirmation -->
    <div class="modal fade" id="feedNowModal" tabindex="-1" aria-labelledby="feedNowModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form wire:submit="feedNow">
  
                  <h2 class="text-lg font-medium text-green-900 dark:text-green-100">
                      {{ __('Are you sure you want to Feed now?')}}
                  </h2>
          
                  <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                      {{ __('Once the Feeding is started it cannot be aborted') }}
                  </p>
          
                  <div class="mt-6 flex justify-end">
                      <button class="ms-3 btn btn-success">
                          {{ __('Feed Now') }}
                      </button>
                  </div>
              </form>
          </div>
        </div>
      </div>
    </div>
  <!--end of div-->
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
    Launch demo modal
  </button>

  <!-- Modal -->
  <div class="modal fade" id="delayModal" tabindex="-1" aria-labelledby="delayModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="delayModalLabel">Please Wait</h1>
        </div>
        <div class="modal-body">
          <div class="progress">
            <div class="progress-bar bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
              
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</div>
@script
 <script>
  $(document).ready(function(){
      $('#searchTxt').on('keyup',function(){
        @this.search = $(this).val();
        @this.call('with');
      })
    });

    $wire.on('opendelay', () => {
      $('#delayModal').modal('show');
      const totalTime = 50000; 
      const interval = 100; // Update every 100ms

      // Calculate how much the progress bar should increase per interval
      const increment = (100 / totalTime) * interval;

      let currentProgress = 0;
      const progressBar = document.querySelector('.progress-bar');

      // Function to update the progress bar
      const updateProgressBar = setInterval(() => {
        currentProgress += increment;
        progressBar.style.width = `${currentProgress}%`;
        progressBar.setAttribute('aria-valuenow', Math.round(currentProgress));

        if (currentProgress >= 100) {
          clearInterval(updateProgressBar);
        }
      }, interval);

      // Set a timeout to reload the page
      setTimeout(() => {
        location.reload();
      }, totalTime);
    });
    $wire.on('openAddNewModal', () => {
      $('#addNewModal').modal('show');
    });
    $wire.on('showEditModal', () => {
      $('#editModal').modal('show');
    });
    $wire.on('showDeleteModal', () => {
      $('#deleteModal').modal('show');
    });
    $wire.on('openFeedNowModal', () => {
      $('#feedNowModal').modal('show');
    });
    $wire.on('close', () => {
      $('#deleteModal').modal('hide');
      $('#feedNowModal').modal('hide');
      $('#editModal').modal('hide');
      $('#addNewModal').modal('hide');
    });

    //get the date
  var x = document.getElementById("feed");
  x.addEventListener("change", myFunction);

function myFunction() {
  var val = x.value;
  val = val.replace("T", " ");
  @this.feed = val+':00';
}

//edit
var y = document.getElementById("time");
  y.addEventListener("change", myFunctionEdit);

function myFunctionEdit() {
  var val = y.value;
  val = val.replace("T", " ");
  @this.time = val+':00';
}

 </script>
@endscript