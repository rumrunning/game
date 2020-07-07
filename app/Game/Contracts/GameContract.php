<?php

namespace App\Game\Contracts;

interface GameContract {

    public function name();

    public function dice();

    public function defaultChanceCalculator() : ChanceCalculatorContract;
}