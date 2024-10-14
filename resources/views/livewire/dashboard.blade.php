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
    public string $unit;
    public string $feed;
    public $time;
    public string $status;
    
    public $perPage = 5;

    //search
    public string $searchtxt = '';

    public $srch;

 

    public function with(): array{
        return [
            'feeds' => Feeding::orderBy('status','DESC')->paginate($this->perPage),
        ];
    }

    //addnew
    public function addNew(){
      $this->dispatch('openAddNewModal');
    }

    public function newDepartment(){
        $validated = $this->validate([
            'desc' => ['required', 'string', 'max:255'],
            'feed' => ['required'], 
        ]);

        Feeding::create([
          'desc' => $validated['desc'],
          'unit' => 1,
          'time' => $validated['feed'],
          'status' => 'pending',
        ]);

        session()->flash('message', 'Added Succesfully');
        $this->redirect(route('dashboard'));
    }

    //feedNow
    public function openFeedNow(){
      $this->dispatch('openFeedNowModal');
    }

    public function feedNow(){
      $newDateTime = Carbon::now()->format('Y-m-d H:i:00');

        Feeding::create([
          'desc' => 'Feed Now',
          'unit' => '1',
          'time' => $newDateTime,
          'status' => 'done',
        ]);

        session()->flash('message', 'Feeded Succesfully');
        $this->redirect(route('dashboard'));
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

    public function search()
    {
        $this->result = [];
        if ($this->searchtxt) {
          $this->srch = 'true';
          $feeds = Feeding::where('time','like', '%'.$this->searchtxt.'%')->get();
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
        else {
          $this->srch = 'false';
        }
    }
}; ?>

<div class="container-sm">
  <div class="container">
    <div class="row">
      <div class="col">
        <button wire:click="addNew()" type="button" class="btn btn-md btn-primary ml-3 mb-3">ADD NEW SCHEDULE</button>
        <button wire:click="openFeedNow()" type="button" class="btn btn-md btn-success ml-3 mb-3">FEED NOW</button>
      </div>
      <div class="col">
        <form class="form-inline" wire:submit="search">
          <div class="input-group">
            <input wire:model="searchtxt" wire:change='search()' id="searchtxt" name="searchtxt" class="form-control" type="search" placeholder="Search Feed Time" aria-label="Search" style="margin-left: 15%">
            <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
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
            @if ($this->srch == 'true')
              @foreach ($this->result as $res)
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
            @else
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
            @endif
        </tbody>
      </table>
      <div class="container-md mt-5">
        <label for="perPage">Entries per page</label>
        <select class="form-select w-25" aria-label="Default select example" id="perPage" wire:change='with()'  wire:model="perPage">
          <option value="5">5</option>
          <option value="10">10</option>
          <option value="15">15</option>
          <option value="20">20</option>
        </select>
        {{$feeds->links()}}
      </div>

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
                    <input type="number" wire:model="unit" id="unit" name="unit" class="mt-1 block w-full form-control" required autocomplete="unit" value="0.5" placeholder="0.5" disabled/>
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