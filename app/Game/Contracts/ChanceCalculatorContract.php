<?php

namespace App\Game\Contracts;

interface ChanceCalculatorContract {

    public function getActionPercentage(ActionContract $action);
}