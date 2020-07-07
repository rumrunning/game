<?php

namespace App\RumRunning\Crimes;

use App\Game\Contracts\ChanceCalculatorContract;
use App\RumRunning\Crimes\Exceptions\NoSuchCrimeAvailable;
use Illuminate\Support\Collection;

class CrimesCollection extends Collection {

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

    public function withCalculatedChances(ChanceCalculatorContract $chanceCalculator)
    {
        $this->map(function(Crime $crime) {
           // $crime->
        });
    }
}