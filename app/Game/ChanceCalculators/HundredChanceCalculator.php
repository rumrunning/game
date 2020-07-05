<?php

namespace App\Game\ChanceCalculators;

use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ChanceCalculatorContract;

class HundredChanceCalculator implements ChanceCalculatorContract {

    public function getActionPercentage(ActionContract $action)
    {
        return 100;
    }
}