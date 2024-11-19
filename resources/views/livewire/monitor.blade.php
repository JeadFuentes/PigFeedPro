<?php

use Livewire\Volt\Component;
use App\Models\Sensordata;
use Carbon\Carbon;

new class extends Component {
    public $level;

    public function mount(){
        $cutoffDate = Carbon::now()->subDays(2);
        Sensordata::where('created_at', '<', $cutoffDate)->delete();

        $level = Sensordata::orderBy('id', 'desc')
                   ->pluck('level')
                   ->first();

        if ($level) {
            /*if ($level >= 0 && $level <= 50) {
                $this->level = 100 - $level * 2;
            } elseif ($level > 50) {
                $this->level = 0;
            } else {
                $this->level = 0; //Handle negative levels as 0.
            }*/

            $this->level = $level;
        }
        else {
            $this->level = 0; // Handle null as 0.
        }

        if ($this->level <= 30) {
            $this->dispatch('openNotif');
        }

    }
}; ?>

<div> 
    <!-- Modal -->
    <div class="modal fade" id="NotifModal" tabindex="-1" aria-labelledby="NotifModal" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-bg-danger">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Alert</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3 class="text-danger">Feed Level Is At {{$this->level}}</h3>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <div id="levels" class="fu-progress">
        <div class="fu-inner">
          <div class="fu-percent percent"><span>50</span>%</div>
          <div class="water"></div>
          <div class="glare"></div>
        </div>
      </div>

      <h2 class="text" style="margin-left:5%">FEEDS TANK LEVEL</h2>
</div>


@script
    <script>
        'use strict';

        var animatePercentChange = function animatePercentChange (newPercent, elem) {
            elem = elem || $('.fu-percent span');
            const val = parseInt(elem.text(), 10);

            if(val !== parseInt(newPercent, 10)) {
                let diff = newPercent < val ? -1 : 1;
                elem.text(val + diff);
                setTimeout(animatePercentChange.bind(null, newPercent, elem), 50);
            }
        };

        $(document).ready(function(){
            const amount = @this.level;
            const currentPercent = $('.fu-percent span').text();
            const waterAnimSpeed = (Math.abs(currentPercent - amount) / 50) * 10;
            const waterPercent = 100 - amount;
            animatePercentChange(amount);
            $('.water').css({
                top : waterPercent + '%'
            });;
        });

        $wire.on('openNotif', () => {
            $('#NotifModal').modal('show');
        });
    </script>
@endscript