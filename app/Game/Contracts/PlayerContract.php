<?php

namespace App\Game\Contracts;

use App\Game\ClaimCollection;

interface PlayerContract {

    public function getKey();

    public function getSkillSetPoints($class);

    public function collectClaimsFor(ActionContract $action, ClaimCollection $claims);

    public function setDefaultActionChanceCalculator(ChanceCalculatorContract $chanceCalculator) : void;

    public function getActionChanceCalculator($class) : ChanceCalculatorContract;
}