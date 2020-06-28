<?php

namespace App\RumRunning;

use App\Game\Game as BaseGame;
use App\Game\Contracts\ActionContract;
use App\Game\Contracts\PlayerContract;
use App\RumRunning\Crimes\Crime;
use App\RumRunning\Crimes\CrimesCollection;

class Game extends BaseGame {

    private $name;

    private $crimes;

    /**
     * Game constructor.
     * @param $name
     * @param $crimes
     */
    public function __construct($name, CrimesCollection $crimes)
    {
        $this->name = $name;

        $this->crimes = $crimes;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return CrimesCollection
     */
    public function getCrimes(): CrimesCollection
    {
        return $this->crimes;
    }

    public function commitCrime(PlayerContract $player, Crime $crime)
    {
        $outcome = $this->skilledAttemptBy($player, $crime)->attempt();
        $outcome->claim();
    }
}