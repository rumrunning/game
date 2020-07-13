<?php

namespace App\Game\Contracts;

use Carbon\Carbon;

interface TimerModelContract {

    public function getEndsAt() : ?Carbon;
}