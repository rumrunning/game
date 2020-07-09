<?php

namespace App\RumRunning\Crimes;

use App\Game\Collections\ActionCollection;
use App\Game\Contracts\ChanceCalculatorContract;
use App\RumRunning\Crimes\Exceptions\NoSuchCrimeAvailable;

class CrimeCollection extends ActionCollection {

    public function select($crimeCode)
    {
        $crime = $this->first(function (Crime $crime, $key) use ($crimeCode) {
            return $crime->getCode() === $crimeCode;
        });

        if (is_null($crime)) {
            throw new NoSuchCrimeAvailable("The crime '$crimeCode' does not exist");
        }

        return $crime;
    }
}