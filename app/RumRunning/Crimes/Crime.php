<?php

namespace App\RumRunning\Crimes;

use App\Game\Contracts\ActionContract;
use Illuminate\Contracts\Support\Arrayable;

class Crime implements ActionContract, Arrayable {

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

    public function toArray()
    {
        return [
            'code' => $this->getCode(),
            'description' => $this->getDescription(),
        ];
    }
}