<?php

namespace App\RumRunning\Crimes;

use App\Game\Contracts\ActionPresenterContract;
use App\Game\Traits\PresentableAction;
use Illuminate\Contracts\Support\Arrayable;

class CrimePresenter implements ActionPresenterContract, Arrayable {

    use PresentableAction;

    /**
     * @var Crime $crime
     */
    private $crime;

    /**
     * CrimePresenter constructor.
     * @param Crime $crime
     */
    public function __construct(Crime $crime)
    {
        $this->crime = $crime;
    }

    public function toArray()
    {
        return [
            'code' => $this->getCode(),
            'description' => $this->getDescription(),
            'user_chance' => $this->getUserChance()
        ];
    }
}