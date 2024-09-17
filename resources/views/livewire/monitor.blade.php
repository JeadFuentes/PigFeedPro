<?php

use Livewire\Volt\Component;
use App\Models\Sensordata;

new class extends Component {
    public $level;

    public function mount(){
        $this->level = Sensordata::orderBy('id', 'desc')
                   ->pluck('level')
                   ->first();
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