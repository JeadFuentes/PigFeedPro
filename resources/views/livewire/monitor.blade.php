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
        // 60 is empty 0 is full
        $level = 100 - $level + 10;

        if ($level > 0) {
            $this->level = $level;
        }
        else{
            $this->level = 0;
        }
    }
}; ?>

<div>
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
    </script>
@endscript