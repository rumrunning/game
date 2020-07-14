<?php

namespace App\RumRunning\Crimes;

use App\Game\ActionChanceOffsetCalculator;
use App\Game\Contracts\ActionContract;
use App\Game\Contracts\ActionPresenterContract;
use App\Game\Contracts\ActionRandomisesChanceContract;
use App\Game\Contracts\TimerRestrictedContract;

class Crime implements ActionContract, TimerRestrictedContract, ActionRandomisesChanceContract {

    private $code;

    private $description;

    private $difficulty;

    private $outcomes;

    /**
     * Crime constructor.
     * @param $code
     * @param $description
     * @param $difficulty
     * @param $outcomes
     */
    public function __construct(string $code, string $description, float $difficulty, array $outcomes)
    {
        $this->code = $code;
        $this->description = $description;
        $this->difficulty = $difficulty;
        $this->outcomes = $outcomes;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array
     */
    public function getRewards(): array
    {
        return $this->outcomes['rewards'];
    }

    /**
     * @return array
     */
    public function getPunishments(): array
    {
        return $this->outcomes['punishments'];
    }

    /**
     * @return float
     */
    public function getDifficulty(): float
    {
        return $this->difficulty;
    }

    public function getPresenter() : ActionPresenterContract
    {
        $presenter = new CrimePresenter($this);
        $presenter->setCode($this->getCode());
        $presenter->setDescription($this->getDescription());

        return $presenter;
    }

    public function getTimer()
    {
        return self::class;
    }

    // In seconds
    public function getTimerDuration()
    {
        return 30;
    }

    public function getChanceOffsetCalculator(): ActionChanceOffsetCalculator
    {
        return new ActionChanceOffsetCalculator($this);
    }
}