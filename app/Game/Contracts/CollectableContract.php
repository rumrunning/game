<?php

namespace App\Game\Contracts;

use App\Game\ClaimsCollector;

interface CollectableContract {

    public function prepareForCollection();

    /**
     * @param $value
     * @param ClaimsCollector $claimsCollector
     * @return mixed
     */
    public function collect($value, ClaimsCollector $claimsCollector);
}