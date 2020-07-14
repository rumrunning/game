<?php

namespace App\Game\Contracts;

use App\Game\ActionChanceOffsetCalculator;

interface ActionRandomisesChanceContract {

    public function getChanceOffsetCalculator() : ActionChanceOffsetCalculator;
}