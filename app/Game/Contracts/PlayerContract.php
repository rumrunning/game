<?php

namespace App\Game\Contracts;

use App\Game\ClaimCollection;

interface PlayerContract {

    public function getSkillSetPoints($class);

    public function collectClaimsFor(ActionContract $action, ClaimCollection $claims);
}